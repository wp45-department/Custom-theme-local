<?php
/* Template Name: Add New Tour */
if (!is_user_logged_in() ) {
   wp_redirect( home_url('login'), 301 );
}
get_header();
$user = wp_get_current_user();
$UserId = $user->ID;

?>
<!-- Demo Section Start -->

<section class="demo-sec-main">
    <div class="container-fluid">
        <div class="demo-inner">
            <div class="demo-box-main-title">
                <h4 style="clear: both"><?php the_title()?></h4>
            </div>
            <hr style="margin-left: 16px">


            <form class="myaccount ps-3" id="tour-form-sumbit" method="post" style="min-width:50%;"
                enctype="multipart/form-data">
                <div id="rep_error"> </div>
                <input type="hidden" value="add_new_tour" name="action" />
                <!-- 2 column grid layout with text inputs for the first and last names -->
                <fieldset class="border p-2 mb-1">
                    <div class="row mb-4">
                        <div class="col">
                            <div class="form-outline">
                                <label class="form-label font-weight-bold" for="form6Example1"><b>Tour Name</b></label>
                                <input type="text" id="form6Example1" class="form-control" name="tour_name" required
                                    value="" />
                            </div>
                        </div>

                    </div>
                    <div class="row mb-4">
                        <label class="form-label font-weight-bold" for="form6Example1"><b>Tour status</b></label>
                        <div class="col">
                            <div class="form-outline">
                                <label class="form-label font-weight-bold" for="form6Example1">Live</label>
                                <input type="checkbox" id="form6Example1" class="form-control1 checkboxes"
                                    name="tour_status" value="1" />

                            </div>
                        </div>

                    </div>
                </fieldset>
                <fieldset class="border p-2 mb-1">
                    <div class="form-outline mb-4">
                        <label class="form-label font-weight-bold" for="form6Example5"><b>Tours Zip File</b></label>
                        <input type="file" name="wp_tour_zip_upload" id="form6Example5" requered class="form-control"
                            value="" />
                    </div>
                </fieldset>
                <fieldset class="border p-2 mb-1">
                    <legend>Tour General settings</legend>
                    <div class="form-outline mb-4">
                        <label class="form-label font-weight-bold" for="form6Example5"><b>logo</b></label>
                        <input type="file" name="logo" id="form6Example5" class="form-control" required value="" />
                    </div>
                    <div class="form-outline mb-4">
                        <label class="form-label font-weight-bold" for="form6Example55"><b>Feature Image</b></label>
                        <input type="file" name="feature_image" id="form6Example55" class="form-control" required
                            value="" />
                    </div>
                    <div class="row mb-4">
                        <label class="form-label font-weight-bold" for="form6Example1"><b>Tour Type</b></label>
                        <div class="col">
                            <div class="form-outline">
                                <label class="form-label font-weight-bold" for="tour_type1">Single</label>
                                <input type="radio" checked id="tour_type1" class="form-control1" name="tour_type"
                                    required value="1" />

                            </div>
                        </div>
                        <div class="col">
                            <div class="form-outline">
                                <label class="form-label font-weight-bold" for="tour_type2">Multiple</label>
                                <input type="radio" id="tour_type2" class="form-control1" name="tour_type" required
                                    value="2" />
                            </div>
                        </div>
                    </div>

                    <div class="form-outline mb-4 singletour">
                        <label class="form-label font-weight-bold" for="form6Example13"><b>Tag line</b></label>
                        <input type="text" name="info_below_logo" id="form6Example13" class="form-control" required
                            value="" />
                    </div>

                    <div class="multitour">
                        <div iv class="addnewtopurresponse">
                            <div class="row mb-4 ">
                                <label class="form-label font-weight-bold" for="form6Example10"><b>Tag Lines and
                                        Name</b></label>
                                <div class="col">
                                    <div class="form-outline">
                                        <label class="form-label font-weight-bold" for="form6Example11">Tour
                                            Name</label>
                                        <input type="text" id="form6Example11" class="form-control" name="tour_names[]"
                                            value="" />

                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-outline">
                                        <label class="form-label font-weight-bold" for="form6Example12">Tour Tag
                                            line</label>
                                        <input type="text" id="form6Example12" class="form-control"
                                            name="tour_tag_line[]" value="" />

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row1 mb-4 ">

                            <button type="button" class="btn btn-primary btn-block mb-4 custom-add-tags">Add New
                                Tag</button>
                        </div>

                    </div>

                    <div class="form-outline mb-4">
                        <label class="form-label font-weight-bold" for="form6Example2"><b>Tv videos and
                                thumbnails</b></label>
                        <input type="file" name="tv_video_url_new[]" id="form6Example2" class="form-control" multiple
                            value="" />
                    </div>

                    <div class="form-outline mb-4">
                        <label class="form-label font-weight-bold" for="form6Example3"><b>Bottom logo</b></label>
                        <input type="file" name="bottom_logo" id="form6Example3" class="form-control" required
                            value="" />
                    </div>

                    <div class="form-outline mb-4">
                        <label class="form-label font-weight-bold" for="form6Example4"><b>Bottom disclaimer
                                text</b></label>
                        <input type="text" name="bottom_disclaimer_text" id="form6Example4" class="form-control"
                            required value="" />
                    </div>

                    <div class="form-outline mb-4">
                        <label class="form-label font-weight-bold" for="form6Example5"><b>Google Analytics
                                code</b></label>
                        <input type="text" name="google_analytics_code" id="form6Example5" class="form-control"
                            value="" />
                    </div>

                    <div class="form-outline mb-4">
                        <label class="form-label font-weight-bold" for="form6Example6"><b>Google Properties
                                ID</b></label>
                        <input type="text" name="google_properties_id" id="form6Example6" class="form-control"
                            value="" />
                    </div>
                </fieldset>
                <fieldset class="border p-2 mb-1">
                    <?php 
                    $args = array(
                        'role'    => 'owner',
                        'orderby' => 'user_nicename',
                        'order'   => 'ASC'
                    );
                    $users = get_users( $args );
                    ?>
                    <div class="form-outline mb-4">
                        <label class="form-label font-weight-bold" for="form6Example5"><b>Owner List</b></label>
                        <select class="form-control" id="owner_list" name="owner_list[]" multiple>
                            <option>Select Owner</option>
                            <?php foreach ($users as $key => $users_value) { ?>
                            <option value="<?php echo $users_value->id;?>">
                                <?php echo $users_value->display_name;?> (<?php echo $users_value->user_email;?>)
                            </option>
                            <?php } ?>
                        </select>
                    </div>
                </fieldset>

                <fieldset class="border p-2 mb-1">
                    <?php 
                    $argnews = array(
                        'role'    => 'viewer',
                        'orderby' => 'user_nicename',
                        'order'   => 'ASC'
                    );
                    $viewer = get_users( $argnews );
                    ?>
                    <div class="form-outline mb-4">
                        <label class="form-label font-weight-bold" for="form6Example5"><b>Viewer List</b></label>
                        <select class="form-control" id="viewer_list" name="viewer_list[]" multiple>
                            <option>Select Viewer</option>
                            <?php foreach ($viewer as $key => $viewer_value) { ?>
                            <option value="<?php echo $viewer_value->id;?>">
                                <?php echo $viewer_value->display_name;?> (<?php echo $viewer_value->user_email;?>)
                            </option>
                            <?php } ?>
                        </select>
                    </div>
                </fieldset>


                <!-- Submit button -->
                <button type="submit" class="btn btn-primary btn-block mb-4">Create Tour</button>
            </form>

        </div>
    </div>

</section>


<?php
get_footer();