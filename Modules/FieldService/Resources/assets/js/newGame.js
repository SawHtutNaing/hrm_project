

// Super Wheel Script

var slices=[];
// jQuery(document).ready(function($){
    _init();
    async function getData() {
        let data=[];
        await $.ajax({
            url: `/game/get/${game_id}/data`,
            type: 'GET',
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            error:(response)=>{
                if(response.status==404){
                    alert('Game not found');
                };
            },
            success: (response)=>{
               data=response.data;
            }
        })
        return data;
    }

    // $('#gameBtn').click(()=>{
    //     $.ajax({
    //         url: `/games/get/${game_id}/data`,
    //         type: 'GET',
    //         headers:{
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         },
    //         success: (response)=>{
    //             slices=response.data;
    //         }
    //     })

    // 'slices'=>$data->slices,
    // 'frame'=>$data->frame ??[],
    // 'type'=>$data->type ?? [],
    // 'text'=>$data->text,
    // 'line'=>$data->line,
    // 'outer'=>$data->outer,
    // 'inner'=>$data->inner,
    // 'center'=>$data->center,
    // 'marker'=>$data->marker ?? [],
    // })
    async function initData(){
        data=await getData();
        slices=[...data.slices];
        data.duration=1000;
        $('.wheel-standard').superWheel({
            slices,
            text : data.text,
            line: data.line,
            outer:data.outer,
            inner: data.inner,
            center: data.center,
            marker: data.maker,
            frame:data.frame,
            type:data.type,
            marker:data.marker,

            selector: "value",
            duration: 8000
        });
    }
    async function _init(){
        await initData();

        function getRandomValidItem(arr) {
            let getItem= Math.floor(Math.random() * arr.length);
            let item=arr[getItem];
            if(isNullOrNan(item.aviaQty) != 0){
                arr[getItem].aviaQty=arr[getItem].aviaQty-1;
                return item.text;
            }else{
                return '@';
            }


        }

        var tick = new Audio('/assets/spinwheel/media/tick.mp3');


        $(document).on('click','.wheel-standard-spin-button',async function(e){
            $(this).text('Please Wait');
            await initData();
            $(this).text('Spinning....');
            const selectedRandomItem = getRandomValidItem(slices) ;
            if(selectedRandomItem == '@'){
                $('.wheel-standard').superWheel('start','aviaQty','@');
            }else{
                $('.wheel-standard').superWheel('start','text',selectedRandomItem);
            }
            $.ajax({
                url: `/game/update/${game_id}/data`,
                type: 'POST',
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                data:{
                    'slices':{
                        slices,
                        text : data.text,
                        line: data.line,
                        outer:data.outer,
                        inner: data.inner,
                        center: data.center,
                        marker: data.maker,
                        frame:data.frame,
                        type:data.type,
                        marker:data.marker,
                        selector: "value",
                        duration: 1000
                    }
                },
                error:(response)=>{
                    console.log(response,'==============');
                },
                success: (response)=>{
                   data=response.data;
                }
            })

            $(this).prop('disabled',true);

        });



        $('.wheel-standard').superWheel('onStart',function(results){


            $('.wheel-standard-spin-button').text('Spinning...');

        });
        $('.wheel-standard').superWheel('onStep',function(results){

            if (typeof tick.currentTime !== 'undefined')
                tick.currentTime = 0;

            tick.play();

        });
        function slowVolume(audioElement) {
            if(audioElement && audioElement.volume ){
                var decreaseVolume = setInterval(function() {

                    if (audioElement.volume > 0.1) {
                            audioElement.volume -= 0.1;
                    } else {
                        audioElement.pause();
                        audioElement.volume = 1; // Reset volume to 1 for subsequent plays
                        clearInterval(decreaseVolume);
                    }
                }, 600);
            }

          }

        $('.wheel-standard').superWheel('onComplete',function(results){
            if(results.text == 'No luck' || results.aviaQty =='@' || isNaN(results.aviaQty)){

                Swal.fire({
                    title: "Sorry!",
                    html: results.message,

                });

                // swal("Oops!", results.message, "error");

            }else{


                var cheeerTick = new Audio('/modules/fieldservice/media/cheer.mp3');

                cheeerTick.play();
                slowVolume(cheeerTick);
                // setTimeout(function() {
                //     cheeerTick.pause(); // Pause after 3 seconds
                //   }, 3000);



                const canvas = document.getElementById('custom')

                const jsConfetti = new JSConfetti({ canvas })
                canvas.style.width='100%';
                setTimeout(() => {
                    jsConfetti.addConfetti({
                        emojis: ['🔸','🔹', '🔺', '🔻', '🔷', '🔸'],
                        emojiSize: 35,
                        confettiNumber: 1000,
                    }).then(() => {

                        canvas.style.width='0';
                    })
                }, 10)

                Swal.fire({
                    title: "Congratulations",
                    icon: "success",
                    html: results.message,
                })
            }


            $('.wheel-standard-spin-button:disabled').prop('disabled',false).text('Spin');


        });


    };




// });
