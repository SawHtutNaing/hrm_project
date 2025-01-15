const controls = document.querySelector('.controls');
// const cameraOptions = document.querySelector('.changeCamera')[0];
const video = document.querySelector('video');
const canvas = document.querySelector('canvas');
var imgSrc='';
let streamStarted = false;
var streamTracks=null;

const screenshot = document.querySelector('.screenshot');
const constraints = {
    video: {
        facingMode:'user',
        width: {
            min: 1280,
            ideal: 1920,
            max: 2560,
        },
        height: {
            min: 720,
            ideal: 1080,
            max: 1440
        },
        mirror: true,
    }
};


function openCamera(exact='user'){
    if (streamStarted) {
            video.play();
            return;
        }

        if ('mediaDevices' in navigator && navigator.mediaDevices.getUserMedia) {
            // Request access to the camera
            const updatedConstraints = {
            ...constraints,
            };
            startStream(updatedConstraints);
        }
}
const startStream = async (constraints) => {
    console.log(constraints);
    const stream = await navigator.mediaDevices.getUserMedia(constraints).then(stream => {
        handleStream(stream);
        streamTracks=stream.getTracks();
    })
    .catch(error => {
        console.error('Error accessing camera:', error);
    });
};

const handleStream = (stream) => {
    video.srcObject = stream;
    video.play();
    screenshot.classList.remove('d-none');
        streamStarted = true;
};




const pauseStream = () => {
    video.pause();
};

const doScreenshot = () => {

    video.pause();
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    canvas.getContext('2d').drawImage(video, 0, 0);
    imgSrc=canvas.toDataURL('image/jpg');
    let file=dataURLtoFile(imgSrc,'checkInPhoto.jpg');
    const fileList = new DataTransfer();
    fileList.items.add(file);
    let files=fileList.files;
    $('#checkInPhoto')[0].files = files;

};
const closeCamera=()=>{
    streamStarted=false;
    streamTracks.forEach(function(track) {
        track.stop(); // This will stop the camera
    })
}

const modeChange=async (mode)=>{
    if (streamStarted) {
        closeCamera(); // Close existing stream if it's active
    }
    constraints.video.facingMode = mode;
    await startStream(constraints);
}
// video.pause();
function dataURLtoFile(dataurl, filename) {
    var arr = dataurl.split(','),
    mime = arr[0].match(/:(.*?);/)[1],
    bstr = atob(arr[1]),
    n = bstr.length,
    u8arr = new Uint8Array(n);
    while (n--) {
    u8arr[n] = bstr.charCodeAt(n);
    }
    return new File([u8arr], filename, { type: 'image/jpg' });
}
