<?php
declare(strict_types=1);

require_once __DIR__ . '/../includes/functions.php';

require_admin();

if (isset($_GET['delete'])) {

    db_execute(
        "DELETE FROM experience WHERE id=?",
        [(int) $_GET['delete']]
    );

    redirect('admin/experience.php');
}

if (is_post()) {

    verify_csrf();

    $id = (int) post('id');

    $data = [
        trim((string) post('role')),
        trim((string) post('company')),
        trim((string) post('period')),
        trim((string) post('description')),
        (int) post('sort_order', 0)
    ];

    if ($id) {

        db_execute(
            "UPDATE experience
             SET role=?, company=?, period=?,
                 description=?, sort_order=?
             WHERE id=?",
            [...$data, $id]
        );

    } else {

        db_execute(
            "INSERT INTO experience
            (role, company, period, description, sort_order)
            VALUES (?, ?, ?, ?, ?)",
            $data
        );

    }

    redirect('admin/experience.php');
}

$edit = isset($_GET['edit'])
    ? db_one(
        "SELECT * FROM experience WHERE id=?",
        [(int) $_GET['edit']]
    )
    : null;

$items = db_all(
    "SELECT * FROM experience ORDER BY sort_order, id"
);

$pageTitle = 'Experience';

require_once __DIR__ . '/layout.php';
?>

<div class="admin-content">

    <div class="admin-page-head">
        <div>
            <span>CONTENT</span>
            <h1>Experience</h1>
        </div>
    </div>

    <form method="POST" class="admin-form">

        <?= csrf_field() ?>

        <input
            type="hidden"
            name="id"
            value="<?= e((string)($edit['id'] ?? 0)) ?>"
        >

        <div class="form-two">

            <div>
                <label>Role</label>
                <input
                    type="text"
                    name="role"
                    required
                    value="<?= e($edit['role'] ?? '') ?>"
                >
            </div>

            <div>
                <label>Company</label>
                <input
                    type="text"
                    name="company"
                    required
                    value="<?= e($edit['company'] ?? '') ?>"
                >
            </div>

        </div>

        <label>Period</label>

        <input
            type="text"
            name="period"
            value="<?= e($edit['period'] ?? '') ?>"
        >

        <label>Description</label>

        <textarea
            name="description"
            rows="10"
        ><?= e($edit['description'] ?? '') ?></textarea>

        <label>Sort Order</label>

        <input
            type="number"
            name="sort_order"
            value="<?= e((string)($edit['sort_order'] ?? 0)) ?>"
        >

        <button class="admin-btn">
            <?= $edit ? 'Update Experience' : 'Add Experience' ?>
        </button>

    </form>


    <div class="admin-table-wrap">

        <table class="admin-table">

            <thead>
                <tr>
                    <th>Role</th>
                    <th>Company</th>
                    <th>Period</th>
                    <th></th>
                </tr>
            </thead>

            <tbody>

            <?php foreach ($items as $item): ?>

                <tr>

                    <td><?= e($item['role']) ?></td>
                    <td><?= e($item['company']) ?></td>
                    <td><?= e($item['period']) ?></td>

                    <td class="actions">

                        <a href="?edit=<?= $item['id'] ?>">
                            Edit
                        </a>

                        <a
                            href="?delete=<?= $item['id'] ?>"
                            onclick="return confirm('Delete this experience?')"
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