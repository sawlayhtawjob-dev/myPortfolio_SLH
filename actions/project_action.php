<?php

declare(strict_types=1);

require_once __DIR__ . '/../includes/functions.php';

require_admin();


if (!is_post()) {
    redirect('admin/profile.php');
}


verify_csrf();


$id = (int) post('id');


$profile = db_one(
    "SELECT *
     FROM profile
     WHERE id = ?
     LIMIT 1",
    [$id]
);


if (!$profile) {

    flash(
        'error',
        'Profile not found.'
    );

    redirect('admin/profile.php');
}


$profileImage =
    $profile['profile_image'];


if (
    isset($_FILES['profile_image']) &&
    $_FILES['profile_image']['error']
        !== UPLOAD_ERR_NO_FILE
) {

    $file =
        $_FILES['profile_image'];


    if (
        $file['error']
        !== UPLOAD_ERR_OK
    ) {

        flash(
            'error',
            'Image upload failed.'
        );

        redirect('admin/profile.php');
    }


    if (
        $file['size'] >
        5 * 1024 * 1024
    ) {

        flash(
            'error',
            'Image must be smaller than 5MB.'
        );

        redirect('admin/profile.php');
    }


    $finfo =
        new finfo(
            FILEINFO_MIME_TYPE
        );


    $mime =
        $finfo->file(
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
            'Only JPG, PNG and WebP are allowed.'
        );

        redirect('admin/profile.php');
    }


    if (
        !is_dir(
            PROFILE_UPLOAD_DIR
        )
    ) {

        mkdir(
            PROFILE_UPLOAD_DIR,
            0755,
            true
        );
    }


    $filename =
        'profile_' .
        time() .
        '_' .
        bin2hex(
            random_bytes(4)
        ) .
        '.' .
        $allowed[$mime];


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
            'Unable to save image.'
        );

        redirect('admin/profile.php');
    }


    $oldImage =
        (string)
        $profile['profile_image'];


    if (
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
        trim(
            (string)
            post('full_name')
        ),

        trim(
            (string)
            post('role')
        ),

        trim(
            (string)
            post('summary')
        ),

        trim(
            (string)
            post('phone')
        ),

        trim(
            (string)
            post('email')
        ),

        trim(
            (string)
            post('location')
        ),

        trim(
            (string)
            post('portfolio_url')
        ),

        trim(
            (string)
            post('github_url')
        ),

        $profileImage,

        $id
    ]
);


flash(
    'success',
    'Profile updated successfully.'
);


redirect(
    'admin/profile.php'
);