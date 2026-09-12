<?php
declare(strict_types=1);

require_once __DIR__ . '/../includes/functions.php';

require_admin();

if (isset($_GET['delete'])) {

    db_execute(
        "DELETE FROM certifications WHERE id=?",
        [(int) $_GET['delete']]
    );

    redirect('admin/certifications.php');
}

if (is_post()) {

    verify_csrf();

    $id = (int) post('id');

    $data = [
        trim((string) post('name')),
        trim((string) post('issuer')),
        trim((string) post('certification_date')),
        trim((string) post('credential_url')),
        (int) post('sort_order', 0)
    ];

    if ($id) {

        db_execute(
            "UPDATE certifications
             SET name=?, issuer=?, certification_date=?,
                 credential_url=?, sort_order=?
             WHERE id=?",
            [...$data, $id]
        );

    } else {

        db_execute(
            "INSERT INTO certifications
            (name, issuer, certification_date,
             credential_url, sort_order)
            VALUES (?, ?, ?, ?, ?)",
            $data
        );

    }

    redirect('admin/certifications.php');
}

$edit = isset($_GET['edit'])
    ? db_one(
        "SELECT * FROM certifications WHERE id=?",
        [(int) $_GET['edit']]
    )
    : null;

$items = db_all(
    "SELECT * FROM certifications ORDER BY sort_order, id"
);

$pageTitle = 'Certifications';

require_once __DIR__ . '/layout.php';
?>

<div class="admin-content">

    <div class="admin-page-head">
        <div>
            <span>CONTENT</span>
            <h1>Certifications</h1>
        </div>
    </div>

    <form method="POST" class="admin-form">

        <?= csrf_field() ?>

        <input
            type="hidden"
            name="id"
            value="<?= e((string)($edit['id'] ?? 0)) ?>"
        >

        <label>Certification Name</label>

        <input
            type="text"
            name="name"
            required
            value="<?= e($edit['name'] ?? '') ?>"
        >

        <label>Issuer</label>

        <input
            type="text"
            name="issuer"
            value="<?= e($edit['issuer'] ?? '') ?>"
        >

        <label>Date</label>

        <input
            type="text"
            name="certification_date"
            value="<?= e($edit['certification_date'] ?? '') ?>"
        >

        <label>Credential URL</label>

        <input
            type="url"
            name="credential_url"
            value="<?= e($edit['credential_url'] ?? '') ?>"
        >

        <label>Sort Order</label>

        <input
            type="number"
            name="sort_order"
            value="<?= e((string)($edit['sort_order'] ?? 0)) ?>"
        >

        <button class="admin-btn">
            <?= $edit ? 'Update Certification' : 'Add Certification' ?>
        </button>

    </form>


    <div class="admin-table-wrap">

        <table class="admin-table">

            <thead>
                <tr>
                    <th>Certification</th>
                    <th>Issuer</th>
                    <th>Date</th>
                    <th></th>
                </tr>
            </thead>

            <tbody>

            <?php foreach ($items as $item): ?>

                <tr>

                    <td><?= e($item['name']) ?></td>
                    <td><?= e($item['issuer']) ?></td>
                    <td><?= e($item['certification_date']) ?></td>

                    <td class="actions">

                        <a href="?edit=<?= $item['id'] ?>">
                            Edit
                        </a>

                        <a
                            href="?delete=<?= $item['id'] ?>"
                            onclick="return confirm('Delete this certification?')"
                            class="danger"
                        >
                            Delete
                        </a>

                    </td>

                </tr>

            <?php endforeach; ?>

            </tbody>

        </table>

    </div>

</div>

</main>
</div>

</body>
</html>