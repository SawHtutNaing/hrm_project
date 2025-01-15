@extends('App.main.navBar')

@section('campaign_icon', 'active')
@section('campaign_show', 'active show')
@section('campaign_list_active', 'active')

@section('styles')
<style>
    .z-index-custom-5{
        z-index: 50 !important;
    }
    .bottomDiv{
        height: 200px;
    }
    .loaded {
        transition: background-image 0.3s ease-in-out;
    }
    .lazy-bg {
    width: 100%;
    height: 300px; /* Set a height for the container */
    background-size: cover;
    background-position: center;
    /* Optionally, add a placeholder background while the image is loading */
    background-color: #f0f0f0;
    }

</style>

@livewireStyles
{{-- <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/intersect@3.x.x/dist/cdn.min.js"></script>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script> --}}
@endsection
@section('title')
<!--begin::Heading-->
<h1 class="text-dark fw-bold my-0 fs-2">View Campaign</h1>
<!--end::Heading-->
<!--begin::Breadcrumb-->
<ul class="breadcrumb fw-semibold fs-base my-1">
    <li class="breadcrumb-item text-muted">Campaign</li>
    {{-- <li class="breadcrumb-item text-muted">
        <a href="" class="text-muted text-hover-primary">Crate</a>
    </li> --}}
    <li class="breadcrumb-item text-dark">View </li>
</ul>
<!--end::Breadcrumb-->
@endsection

@section('content')

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Container-->
    <div class="container-xxl" id="">


            <livewire:CampaignInfo :id="$campaign->id" />

        <ul class="nav nav-tabs nav-line-tabs nav-line-tabs-2x mb-5 fs-6">

            @if (hasView('campaign report'))
            <li class="nav-item">
                <a class="nav-link  text-active-gray-700 fw-semibold " href="{{route('campaign.showOar',$campaign->id)}}" >Campaign
                    Report</a>
            </li>
            @endif
            @if (hasView('attendance'))
                <li class="nav-item">
                    <a class="nav-link  text-active-gray-700 fw-semibold " href="{{route('campaign.showAL',$campaign->id)}}"  href="#">Attendance</a>
                </li>
            @endif
            <li class="nav-item">
                <a class="nav-link text-active-gray-700 fw-semibold active"  href="#">Photo Gallery</a>
            </li>

            @if (hasView('campaign report'))
            <li class="nav-item">
                <a class="nav-link text-active-gray-700 fw-semibold"  href="{{route('campaign.showPs',$campaign->id)}}">Product Summary Report</a>
            </li>
            @endif
        </ul>
        <livewire:fieldservice.ImageGralleryComponent :campaign_id="$campaign->id" />


    </div>
    <!--end::Container-->
</div>

<div class="modal fade editmodal" tabindex="-1" id="editt">
</div>



@endsection

@push('scripts')

<script src="{{asset('assets/plugins/custom/fslightbox/fslightbox.bundle.js')}}"></script>
{{-- post --}}
<script>

    var modal = new bootstrap.Modal($('#modal'));
    $('#addPhoto').click(function(){
        modal.show()
    });
    let campaign_id={{$campaign->id}};
    let authUserId={{Auth::user()->id}};
    let currentPage=0;
    let lastPage=1;
    let path="{{asset('storage/gallery/')}}";
    fetchData();
    window.addEventListener('scroll', scrollHandler);

    $(document).on('click', '.editmodalbtn', function(){
        let id=$(this).data('id');

        loadingOn();
        $('.editmodal').load(`/gallery/${id}/edit`, function() {
            $(this).modal('show');
            loadingOff();
        });
    });

    async function scrollHandler() {
        let contentDiv = document.getElementById('bottomDiv');
        if (window.innerHeight + window.scrollY >= contentDiv.offsetTop + contentDiv.offsetHeight ) {
            await fetchData();
            // setTimeout(function() {
            //     // Example: Load more content dynamically
            //     let newContent = document.createElement('p');
            //     newContent.textContent = 'More content';
            //     contentDiv.appendChild(newContent);
            // }, 1000); // Delay in milliseconds
        }
    }

     function fetchData() {
        if(currentPage<lastPage){

            currentPage++;
            $('#loadingPost').removeClass('d-none');
            $.ajax({
                url: `/gallery/get/${campaign_id}/data?page=${currentPage}`,
                type: 'GET',
                error:function(response){
                    this.submitBtn.text='Save';
                    this.submitBtn.disable=false;
                },
                success: (response)=>{
                    if(response.data.length <=0){
                        $('#loadingPost').addClass('d-none');
                    }
                    lastPage=response.last_page;
                    response.data.forEach(function(d,i){
                        let imgs=JSON.parse(d.images);
                        let imageDiv='';
                        let padding=5;
                        let zIndex=3;
                        imgs.forEach((img,index)=>{
                            imageDiv+=`
                            <div class="w-auto min-h-50px ps-2 ${index>0 ? 'position-absolute position-md-static z-index-'+zIndex+' ps-'+padding+' ps-md-0' : 'z-index-custom-5'}">
                                <a class="d-block overlay w-200px h-200px" data-fslightbox="lightbox-basic-${i}" href="${path}/${img}">

                                    <div data-src='${path}/${img}'  class="overlay-wrapper bgi-no-repeat bg-gray-300 bgi-position-center bg-secondary bgi-size-cover card-rounded min-h-175px  w-200px h-200px lazy-bg"
                                        style="backgroun-color:gray;background-image:url(${path}/${img})">
                                    </div>
                                    <div class="overlay-layer card-rounded bg-dark bg-opacity-25 shadow ">
                                        <i class="bi bi-eye-fill text-white fs-3x"></i>
                                    </div>
                                </a>
                            </div>
                            `;
                            padding+=4;
                            zIndex--;
                        })
                        // $profile='';

                        let profile='';
                        if(d.user.personal_info.profile_photo == null){
                            profile=`
                                    <div class="symbol-label fs-3 bg-light-primary text-primary">
                                        ${d.user.username[0]}
                                    </div>
                            `
                        }else{
                            profile=`
                                <img src="${d.user.personal_info.profile_photo}" width="100" heigh="100" />
                            `;
                        }
                        let actions='';
                        if(d.created_by==authUserId){
                            actions +=`
                            <div class="cursor-pointer px-3" id="DropDown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-gear cursor-pointer"></i>
                            </div>
                            <div class="z-3">
                                <ul class="dropdown-menu z-10 py-2 px-2 " aria-labelledby="DropDown" role="menu">
                                    <a class="dropdown-item p-1 view_detail  fw-semibold editmodalbtn" type="button" data-id="${d.id}">
                                        Edit
                                    </a>
                                    <a class="dropdown-item p-1 view_detail text-danger  fw-semibold removePost" type="button" data-href=""
                                        data-id="${d.id}">
                                        Delete
                                    </a>
                                </ul>
                            </div>`
                        }
                        $('.galleries').append(

                        `<div class="card mb-5 post-card">
                            <div class="card-body px-5">
                                <div class="d-flex mb-5">

                                    <div class="symbol symbol-40px me-3">
                                        ${profile}
                                    </div>
                                    <div class="">
                                        <div class='d-flex  justify-content-start gap-2 align-items-center'>
                                            <span class="fw-semibold fs-5">${d.user.personal_info.first_name ?? ''} ${d.user.personal_info.last_name ?? ''}</span>

                                            <div  class="text-end">
                                                ${actions}

                                            </div>
                                        </div>
                                        <span class="fw- fs-8">${d.created_at}</span>
                                    </div>
                                </div>
                                <div class="">
                                    <p class="fs-7 fw-semibold text-gray-700">
                                        ${d.note ?? ''}
                                    </p>
                                </div>
                                <div class="p-0 row  justify-content-start align-items-center gap-5 position-relative">
                                    ${imageDiv}
                                </div>
                            </div>
                        </div>`
                        );
                        refreshFsLightbox();

                        $('#loadingPost').addClass('d-none');
                    })
                }
            })
        }
    }

</script>

{{-- post edit --}}
<script>
    $('#images').change((event) => {
        $('.preview').html('');
        if(event.target.files[0]){
            var files=event.target.files;
            var fileName = '';
            console.log(files);
            files.forEach((f,i)=>{
                fileName+=f.name+'<br>';
                url=URL.createObjectURL(f);
                $('.preview').append(`
                <div class="w-auto h-100px position-relative img-preview">
                    <img  src="${url}" alt=""  height="100px">
                    <div class="remove  position-absolute" style="right: -5px; top:-2px" data-index=${i}>
                        <i class="fa-solid fa-xmark-circle text-danger fs-3 cursor-pointer"></i>
                    </div>
                </div>
                `);
            })
            // $('#fileText').html(fileName);
        }else{
            $('#fileText').text('click to upload.');
        }
    });
    $(document).on('click','.remove',function(){
        $(this).closest(".img-preview").remove();
        const indexToRemove = $(this).data('index');
        const input = $('#images');
        let files = Array.from(input.prop('files'));

        // Remove the file at the specified index from the array
        files = files.filter((file, index) => index !== indexToRemove);
        console.log(files);

        // Clear the input field
        input.val('');

        // Re-populate the input field with the updated files array
        const fileList = new DataTransfer();
        files.forEach((file,i) => {
            fileList.items.add(file);
        });

        input[0].files = fileList.files;
        console.log(fileList.files);
    })


    $(document).on('change','#newimages',function(event){
        $('.newImagePreview').html('');
        if(event.target.files[0]){
            var files=event.target.files;
            var fileName = '';
            console.log(files,'====');
            files.forEach((f,i)=>{
                fileName+=f.name+'<br>';
                url=URL.createObjectURL(f);
                $('.newImagePreview').append(`
                <div class="w-auto h-100px position-relative img-preview">
                    <img  src="${url}" alt=""  height="100px">
                    <div class="newimagesRemove  position-absolute" style="right: -5px; top:-2px" data-index="${i}">
                        <i class="fa-solid fa-xmark-circle text-danger fs-3 cursor-pointer"></i>
                    </div>
                </div>
                `);
            })
            // $('#fileText').html(fileName);
        }else{
            $('#fileText').text('click to upload.');
        }
    });
    $(document).on('click','.newimagesRemove',function(){
        $(this).closest(".img-preview").remove();
        const indexToRemove = $(this).data('index');
        const input = $('#newimages');
        let files = Array.from(input.prop('files'));

        // Remove the file at the specified index from the array
        files = files.filter((file, index) => index !== indexToRemove);
        console.log(files);

        // Clear the input field
        input.val('');

        // Re-populate the input field with the updated files array
        const fileList = new DataTransfer();
        files.forEach((file,i) => {
            fileList.items.add(file);
        });

        input[0].files = fileList.files;
    })

    $(document).on("click",'.remove-added',function(){
        let removeFile=$('#remove_file');
        let filename=$(this).data('image');
        let filedata=JSON.parse(removeFile.val());
        filedata.push(filename);
        filedata = JSON.stringify(filedata);
        removeFile.val(filedata);
        $(this).closest(".img-added-preview").remove();
    })
</script>
{{-- post delete --}}
<script>
        // Attach click event listener to all delete buttons in the table
    $(document).on('click', '.removePost', function (e) {
        e.preventDefault();
        let id = $(this).data('id');
        Swal.fire({
            title: 'Are you sure?',
            text: "You want to Delete this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#f1416c',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                url:`/gallery/${id}/delete`,
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: (s)=> {
                    $(this).closest('.post-card').remove();
                    success('Successfully Deleted');
                },
                errror:()=>{
                    error('Something Wrong');
                }
            })
            }
        });
    });

</script>
@livewireScripts


@endpush
