<div class="row">

<div class="col-md-12">

<div class="box">
                <div class="box-header">
                  <h3 class="box-title">New Part</h3>
                  
                  <div class="box-tools" style="top:-8px">
                  
                  
                    
                  </div>
                </div><!-- /.box-header -->
                <div class="box-body no-padding">
                
                <div class="tabs-framed">
    <ul class="tabs clearfix">
        <li class="active"><a href="#tab-photos" data-toggle="tab" aria-expanded="true"><i class="fa fa-camera"></i> Upload Photos</a></li>
        <li class=""><a href="#tab-details" data-toggle="tab" aria-expanded="false"><i class="fa fa-edit"></i> Part Details</a></li>
        <li class=""><a href="#tab-meta" data-toggle="tab" aria-expanded="false"><i class="fa fa-plus"></i> Extra Details</a></li>
        <li class=""><a href="#tab-location" data-toggle="tab" aria-expanded="false"><i class="fa fa-map-marker"></i> Location Details</a></li>
       <!-- <li class=""><a href="#tab-finish" data-toggle="tab">Step 4 : Finish</a></li>-->
    </ul>

    <div class="tab-content">
        <!-- Photos -->
        <div class="tab-pane fade active in" id="tab-photos">
            <div class="tab-body">
            
            <!--PhotoHeader-->
                <div class="page-header top sabian_proile_header">
                
                <div class="bryo_droppable" id="photo_upload_drag" style="border: medium hidden rgb(187, 187, 187);">
                <a class="btn btn-primary" data-upload-url="http://localhost/sabianrental/actions/upload_pics.php" data-main-url="http://localhost/sabianrental/actions/" data-source-url="http://localhost/sabianrental/admin/json/gallery.php" id="sabian_btn_photo_add">
                    <span class="fa fa-fw fa-camera"></span> Upload Photos
                  </a>
                  </div>
                  
                </div>
                
                <form action="http://localhost/sabianrental/actions/upload_pics.php" data-main-url="http://localhost/sabianrental/actions/" method="post" enctype="multipart/form-data" id="sabian_form_photo_add" style="display:none">
                <input type="file" name="file_form_photo_add" id="file_form_photo_add" multiple="">
                </form>
                <!--PhotoContent-->
                
                <div class="row" id="photo_add_container">
                
                <!--imgTemplate-->
                
                <!--imgTemplate-->
                </div>
                
                </div>
        </div>
        
        <!-- House Details-->
        <div class="tab-pane fade" id="tab-details">
            <div class="tab-body">
               
                <div class="wp-block default user-form"> 
                            <div class="form-header">
                                <h2>Enter Part Details</h2>
                            </div>
                            <div class="form-body">
							
							
<form id="product_upload_form" class="sky-form" method="post">                                    
                                    <fieldset>                  
                                        <section>
                                            <div class="form-group">
                                                <label class="label">Title</label>
                                                <label class="input">
                                                    <i class="icon-append fa fa-user"></i>
                                                    <input type="text" name="title">
                                                </label>
                                            </div>     
                                        </section>
                                        
                                        <section>
                                        <label class="label">Property Description</label>
                                            <label class="textarea">
                                                <textarea rows="10" cols="300" name="description" placeholder="Enter Property Decription" style="height:200px"></textarea>
                                            </label>
                                        </section>
                                        
                                        
                                                
                                                
                                                 <section>
                                                    <label class="label">Property Category</label>
                                                    <label class="select">
                                                    <select name="category">
                                                                                                                <option value="3">Flat</option>
                                                                                                                <option value="2">Apartment</option>
                                                                                                                </select>
                                                    <i></i>
                                                </label>
                                                </section>
                                                
                                                <section>
                                                    <label class="label">Property Status</label>
                                                    <label class="select">
                                                    <select name="type">
                                                                                                            <option value="For Rent">For Rent</option>
                                                        
                                                                                                                <option value="For Sale">For Sale</option>
                                                        
                                                                                                                </select>
                                                    <i></i>
                                                </label>
                                                </section>
                                                
                                                <section>
                                                    <label class="label">Standard Price (KES)</label>
                                                    <label class="input">
                                                        <i class="icon-append fa fa-user"></i>
                                                        <input type="number" min="0" value="0" name="adultsprice" placeholder="">
                                                    </label>
                                                </section>
                                       
                                       
                                        <section>
                                                    <label class="label">Number of Rooms</label>
                                                    <label class="input">
                                                        <i class="icon-append fa fa-tint"></i>
                                                        <input type="number" min="0" value="0" name="rooms" placeholder="">
                                                    </label>
                                                </section>
                                                
                                                
                                                
                                                 </fieldset> 
                                                 
                                                  <input type="hidden" name="longitude" value="" id="location_longitude">
                                                   <input type="hidden" name="latitude" value="" id="location_latitude">
                                                   <input type="hidden" name="city" value="Nairobi" id="location_city">
                                                   <input type="hidden" name="country" value="Kenya" id="location_country">
                                                   <input type="hidden" name="place" value="Nairobi" id="location_place">
                                                  <input type="hidden" name="main_photo" value="-1" id="main_photo" data-src="-1">
                                                 </form></div>
                               
                            <div class="form-footer">
                                <p></p>
                           </div>
                            
                        </div>
               
            </div>
        </div>
        
        <!--Meta Information-->
        <div class="tab-pane fade" id="tab-meta">
            <div class="tab-body">
               
                <div class="wp-block default user-form"> 
                            <div class="form-header">
                                <h2>Enter Extra Details &nbsp;&nbsp;
                                <a class="btn btn-primary" id="sabian_add_room" data-upload-url="http://localhost/sabianrental/actions/upload_pics.php" data-main-url="http://localhost/sabianrental/actions/" data-source-url="http://localhost/sabianrental/admin/json/gallery.php" style="display:none"><span class="fa fa-plus"></span> Add New Room</a>
                                
                                
                                <a data-toggle="modal" href="#property_meta_modal" class="btn btn-primary" title="Click to Select Property Details"><span>Select Details</span></a>
                                
                                </h2>
                            </div>
                            <div class="form-body">
                            
                            <div class="row" id="sabian_room_container"></div>
                            
                            <div class="row" id="sabian_meta_container"></div>
                            
                            </div>
                               
                            <div class="form-footer">
                                <p></p>
                           </div>
                            
                        </div>
               
            </div>
        </div>
        
        <!-- House Location-->
        <div class="tab-pane fade" id="tab-location">
            <div class="tab-body">
             <div class="wp-block default user-form"> 
                            <div class="form-header">
                                <h2>Enter Location Details</h2>
                            </div>
                            <div class="form-body">
                            
                            <div id="sabian_map" class="sabian_map"></div>
                            
                            <input type="text" id="sabian_map_search" class="sabian_map_controls" style="padding:5dp" placeholder="Search Place Name">
                            
               <!--<form id="hotel_location_form" class="sky-form" method="post">                                    
                                    <fieldset>                  
                                        <section>
                                            <div class="form-group">
                                                <label class="label">Place</label>
                                                <label class="input">
                                                    <i class="icon-append fa fa-user"></i>
                                                    <input type="text" name="place" id="place">
                                                </label>
                                            </div>     
                                        </section>
                                         <section>
                                            <div class="form-group">
                                                <label class="label">City</label>
                                                <label class="input">
                                                    <i class="icon-append fa fa-user"></i>
                                                    <input type="text" name="city" autocomplete="off" id="city">
                                                </label>
                                            </div>     
                                        </section>
                                         <section>
                                            <div class="form-group">
                                                <label class="label">Country</label>
                                                <label class="input">
                                                    <i class="icon-append fa fa-user"></i>
                                                    <input type="text" name="country" autocomplete="off" id="country">
                                                </label>
                                            </div>     
                                        </section>
                                         <section>
                                            <div class="form-group">
                                                <label class="label">Longitude</label>
                                                <label class="input">
                                                    <i class="icon-append fa fa-user"></i>
                                                    <input type="text" name="longitude" id="longitude">
                                                </label>
                                            </div>     
                                        </section>
                                         <section>
                                            <div class="form-group">
                                                <label class="label">Latitude</label>
                                                <label class="input">
                                                    <i class="icon-append fa fa-user"></i>
                                                    <input type="text" name="latitude" id="latitude">
                                                </label>
                                            </div>     
                                        </section>
                                        </fieldset>
                                        </form>-->
                                        </div>
                                        
                                        <div class="form-footer">
                                <p>
                                <!--ajax_loader-->
                                </p><div style="color:red; font-weight:bold" id="publish_error_output"></div>
                                
                                <div id="publish_output"></div>
                                
                                <div id="publish_loader" style="display:none"><img src="http://localhost/sabianrental/images/loader/loader16.gif"> Publishing..</div>
                                
                                <a class="btn btn-primary" id="publish_house" data-parent="#hotel_upload_form" data-url="http://localhost/sabianrental/actions/new_property.php" data-output="#publish_output" data-error-output="#publish_error_output" data-loading-text="#publish_loader" href="#">
                    <span class="fa fa-fw fa-check"></span> Publish Property
                  </a>
                  <!--ajax_settings-->
                  <p></p>
                           </div>
                                        
                                        </div>
                                        
            </div>
            </div>
            
            <!-- House Confirm-->
        <div class="tab-pane fade" id="tab-finish">
            <div class="tab-body">
                finish
            </div>
            </div>

    </div>
</div>
               
                
                  
                </div><!-- /.box-body -->
              </div>

</div>

</div>