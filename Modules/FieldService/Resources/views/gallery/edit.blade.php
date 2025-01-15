<div class="modal-dialog w-md-600px mt-10   modal-dialog-scrollable "  >
    <div class="modal-content mb-20">
        <div class="modal-header py-2">
            <h3 class="modal-title">Edit Photo</h3>
            <!--begin::Close-->
            <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
            </div>
            <!--end::Close-->
        </div>

            <form action="{{route('gallery.update',$gallery->id)}}" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                        @csrf
                        <textarea class="form-control" data-kt-autosize="true" name="note" placeholder="Add Note">{{$gallery->note}}</textarea>
                        <div class="fv-row">
                            <div class="dropzone mt-3 p-4" id="">
                                <label for="newimages" class="dz-message cursor-pointer">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <i class="ki-duotone ki-some-files fs-1 text-primary"><span class="path1"></span><span class="path2"></span></i>
                                        <div class="ms-4">
                                            <h3 class="fs-6 fw-bold text-gray-900 mb-1" id="fileText"> click to upload image.</h3>
                                        </div>
                                    </div>
                                </label>
                                <input  type="file" class="d-none" id="newimages" name="newimages[]" accept=".jpg,.png" multiple>
                                <input type="hidden" id="remove_file" value='["image"]' name="remove_file" >
                            </div>
                        </div>
                        <div class="newImagePreview   row mt-3  g-1 d-flex flex-nowrap overflow-x-scroll gap-1">

                        </div>
                        <div class="photo row mt-3 p-5 g-1 d-flex flex-nowrap overflow-x-scroll gap-3 " style="height: 80%; overflow: scroll;">
                            @php
                                $images=json_decode($gallery->images);
                                $padding=5;
                                $zIndex=3;
                            @endphp
                            @foreach ($images as $Iindex=>$image)
                                <div class="w-auto img-added-preview position-relative">
                                    <div class="overlay-wrapper bgi-no-repeat bgi-position-center bgi-size-cover card-rounded min-h-175px  w-200px h-200px"
                                        style="background-image:url('{{asset('storage/gallery/'.$image)}}')">
                                    </div>
                                    <div  data-image="{{$image}}"  class="remove-added  position-absolute" style="right: -5px; top:-5px" data-index=${i}>
                                        <i class="fa-solid fa-xmark-circle text-danger fs-1 cursor-pointer"></i>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal" aria-label="Close">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
        </form>
    </div>
</div>
