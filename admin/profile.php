<?php

declare(strict_types=1);

require_once __DIR__ . '/../includes/functions.php';

require_admin();


$profile = db_one(
    "SELECT * FROM profile
     ORDER BY id ASC
     LIMIT 1"
);


if (!$profile) {

    exit('Profile record not found.');
}


if (is_post()) {

    verify_csrf();


    $fullName = trim(
        (string) post('full_name')
    );

    $role = trim(
        (string) post('role')
    );

    $summary = trim(
        (string) post('summary')
    );

    $phone = trim(
        (string) post('phone')
    );

    $email = trim(
        (string) post('email')
    );

    $location = trim(
        (string) post('location')
    );

    $portfolioUrl = trim(
        (string) post('portfolio_url')
    );

    $githubUrl = trim(
        (string) post('github_url')
    );


    /*
    |--------------------------------------------------------------------------
    | Profile Image
    |--------------------------------------------------------------------------
    */

    $profileImage =
        $profile['profile_image'];


    if (
        isset($_FILES['profile_image']) &&
        $_FILES['profile_image']['error']
            !== UPLOAD_ERR_NO_FILE
    ) {

        $file = $_FILES['profile_image'];


        if (
            $file['error']
            !== UPLOAD_ERR_OK
        ) {

            flash(
                'error',
                'Profile image upload failed.'
            );

            redirect('admin/profile.php');
        }


        /*
        |--------------------------------------------------------------------------
        | File Size
        |--------------------------------------------------------------------------
        */

        $maxSize = 5 * 1024 * 1024;

        if ($file['size'] > $maxSize) {

            flash(
                'error',
                'Image must be smaller than 5MB.'
            );

            redirect('admin/profile.php');
        }


        /*
        |--------------------------------------------------------------------------
        | MIME Validation
        |--------------------------------------------------------------------------
        */

        $finfo = new finfo(
            FILEINFO_MIME_TYPE
        );

        $mime = $finfo->file(
            $file['tmp_name']
        );


        $allowed = [
            'image/jpeg' => 'jpg',
            'image/png'  => 'png',
            'image/webp' => 'webp'
        ];


        if (!isset($allowed[$mime])) {

            flash(
                'error',
                'Only JPG, PNG and WebP images are allowed.'
            );

            redirect('admin/profile.php');
        }


        /*
        |--------------------------------------------------------------------------
        | Create upload directory
        |--------------------------------------------------------------------------
        */

        if (
            !is_dir(PROFILE_UPLOAD_DIR)
        ) {

            mkdir(
                PROFILE_UPLOAD_DIR,
                0755,
                true
            );
        }


        /*
        |--------------------------------------------------------------------------
        | New filename
        |--------------------------------------------------------------------------
        */

        $extension =
            $allowed[$mime];

        $filename =
            'profile_' .
            time() .
            '_' .
            bin2hex(
                random_bytes(4)
            ) .
            '.' .
            $extension;


        $destination =
            PROFILE_UPLOAD_DIR .
            $filename;


        if (
            !move_uploaded_file(
                $file['tmp_name'],
                $destination
            )
        ) {

            flash(
                'error',
                'Unable to save uploaded image.'
            );

            redirect('admin/profile.php');
        }


        /*
        |--------------------------------------------------------------------------
        | Delete previous uploaded profile image
        |--------------------------------------------------------------------------
        */

        $oldImage =
            (string)
            $profile['profile_image'];


        if (
            $oldImage !== '' &&
            strpos(
                $oldImage,
                'assets/images/profile_'
            ) === 0
        ) {

            $oldFile =
                ROOT_PATH .
                '/' .
                $oldImage;


            if (
                is_file($oldFile)
            ) {

                @unlink($oldFile);
            }
        }


        $profileImage =
            'assets/images/' .
            $filename;
    }


    /*
    |--------------------------------------------------------------------------
    | Update Profile
    |--------------------------------------------------------------------------
    */

    db_execute(
        "UPDATE profile SET
            full_name = ?,
            role = ?,
            summary = ?,
            phone = ?,
            email = ?,
            location = ?,
            portfolio_url = ?,
            github_url = ?,
            profile_image = ?
         WHERE id = ?",
        [
            $fullName,
            $role,
            $summary,
            $phone,
            $email,
            $location,
            $portfolioUrl,
            $githubUrl,
            $profileImage,
            $profile['id']
        ]
    );


    flash(
        'success',
        'Profile updated successfully.'
    );


    redirect('admin/profile.php');
}


$pageTitle = 'Profile';

require_once __DIR__ . '/layout.php';

?>


<div class="admin-content">


    <div class="admin-page-head">

        <div>

            <span>CONTENT</span>

            <h1>Profile</h1>

        </div>

    </div>


    <?php if ($msg = flash('success')): ?>

        <div class="admin-alert success">
            <?= e($msg) ?>
        </div>

    <?php endif; ?>


    <?php if ($msg = flash('error')): ?>

        <div class="admin-alert error">
            <?= e($msg) ?>
        </div>

    <?php endif; ?>


    <form
        method="POST"
        enctype="multipart/form-data"
        class="admin-form"
    >

        <?= csrf_field() ?>


        <!-- Profile Image -->

        <div class="profile-image-admin">

            <label>
                Profile Image
            </label>


            <div class="profile-image-preview">

                <?php
                $imagePath =
                    $profile['profile_image']
                    ?: 'assets/images/profile.jpg';

                $imageUrl =
                    url($imagePath);
                ?>

                <img
                    src="<?= e($imageUrl) ?>?v=<?= time() ?>"
                    alt="Profile"
                    id="profilePreview"
                >

            </div>


            <input
                type="file"
                name="profile_image"
                id="profileImageInput"
                accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
            >


            <small>
                JPG, PNG or WebP — Maximum 5MB
            </small>

        </div>


        <div class="form-two">


            <div>

                <label>
                    Full Name
                </label>

                <input
                    type="text"
                    name="full_name"
                    value="<?= e($profile['full_name']) ?>"
                    required
                >

            </div>


            <div>

                <label>
                    Role
                </label>

                <input
                    type="text"
                    name="role"
                    value="<?= e($profile['role']) ?>"
                    required
                >

            </div>


        </div>


        <label>
            Professional Summary
        </label>


        <textarea
            name="summary"
            rows="8"
        ><?= e($profile['summary']) ?></textarea>


        <div class="form-two">


            <div>

                <label>
                    Phone
                </label>

                <input
                    type="text"
                    name="phone"
                    value="<?= e($profile['phone']) ?>"
                >

            </div>


            <div>

                <label>
                    Email
                </label>

                <input
                    type="email"
                    name="email"
                    value="<?= e($profile['email']) ?>"
                >

            </div>


        </div>


        <div class="form-two">


            <div>

                <label>
                    Location
                </label>

                <input
                    type="text"
                    name="location"
                    value="<?= e($profile['location']) ?>"
                >

            </div>


            <div>

                <label>
                    Portfolio URL
                </label>

                <input
                    type="url"
                    name="portfolio_url"
                    value="<?= e($profile['portfolio_url']) ?>"
                >

            </div>


        </div>


        <label>
            GitHub URL
        </label>


        <input
            type="url"
            name="github_url"
            value="<?= e($profile['github_url']) ?>"
        >


        <button
            type="submit"
            class="admin-btn"
        >
            Save Profile
        </button>


    </form>

</div>


<script>

(function () {

    const input =
        document.getElementById(
            'profileImageInput'
        );

    const preview =
        document.getElementById(
            'profilePreview'
        );


    if (!input || !preview) {
        return;
    }


    input.addEventListener(
        'change',
        function () {

            const file =
                this.files &&
                this.files[0];


            if (!file) {
                return;
            }


            const allowed = [
                'image/jpeg',
                'image/png',
                'image/webp'
            ];


            if (
                !allowed.includes(
                    file.type
                )
            ) {

                alert(
                    'Only JPG, PNG and WebP images are allowed.'
                );

                this.value = '';

                return;
            }


            if (
                file.size >
                5 * 1024 * 1024
            ) {

                alert(
                    'Image must be smaller than 5MB.'
                );

                this.value = '';

                return;
            }


            const reader =
                new FileReader();


            reader.onload =
                function (event) {

                    preview.src =
                        event.target.result;

                };


            reader.readAsDataURL(file);

        }
    );

})();

</script>


</main>
</div>
</body>
</html>