<div class="image-upload-container profile-user-photo-container" style="width: 140px; height: 140px;">
    <?php
        /* Get original profile image URL */

        $profileImageExt = pathinfo($user->getProfileImage()->getUrl(), PATHINFO_EXTENSION);

        $profileImageOrig = preg_replace('/.[^.]*$/', '', $user->getProfileImage()->getUrl());
        $defaultImage = (basename($user->getProfileImage()->getUrl()) == 'default_user.jpg' || basename($user->getProfileImage()->getUrl()) == 'default_user.jpg?cacheId=0') ? true : false;
        $profileImageOrig = $profileImageOrig . '_org.' . $profileImageExt;

        if (!$defaultImage) {
    ?>

        <!-- profile image output-->
        <a data-toggle="lightbox" data-gallery="" href="<?php echo $profileImageOrig; ?>#.jpeg"  data-footer='<button type="button" class="btn btn-primary" data-dismiss="modal"><?php echo Yii::t('FileModule.widgets_views_showFiles', 'Close'); ?></button>'>
            <img class="img-rounded profile-user-photo" id="user-profile-image"
                 src="<?php echo $user->getProfileImage()->getUrl(); ?>"
                 data-src="holder.js/140x140" alt="140x140" style="width: 140px; height: 140px;"/>
        </a>

    <?php } else { ?>

        <img class="img-rounded profile-user-photo" id="user-profile-image"
             src="<?php echo $user->getProfileImage()->getUrl(); ?>"
             data-src="holder.js/140x140" alt="140x140" style="width: 140px; height: 140px;"/>

    <?php } ?>
</div>