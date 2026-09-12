<?php
declare(strict_types=1);

require_once __DIR__ . '/../includes/functions.php';

require_admin();

if (isset($_GET['delete'])) {

    db_execute(
        "DELETE FROM education WHERE id=?",
        [(int) $_GET['delete']]
    );

    redirect('admin/education.php');
}

if (is_post()) {

    verify_csrf();

    $id = (int) post('id');

    $data = [
        trim((string) post('degree')),
        trim((string) post('institution')),
        trim((string) post('period')),
        trim((string) post('description')),
        (int) post('sort_order', 0)
    ];

    if ($id) {

        db_execute(
            "UPDATE education
             SET degree=?, institution=?, period=?,
                 description=?, sort_order=?
             WHERE id=?",
            [...$data, $id]
        );

    } else {

        db_execute(
            "INSERT INTO education
            (degree, institution, period, description, sort_order)
            VALUES (?, ?, ?, ?, ?)",
            $data
        );

    }

    redirect('admin/education.php');
}

$edit = isset($_GET['edit'])
    ? db_one(
        "SELECT * FROM education WHERE id=?",
        [(int) $_GET['edit']]
    )
    : null;

$items = db_all(
    "SELECT * FROM education ORDER BY sort_order, id"
);

$pageTitle = 'Education';

require_once __DIR__ . '/layout.php';
?>

<div class="admin-content">

    <div class="admin-page-head">
        <div>
            <span>CONTENT</span>
            <h1>Education</h1>
        </div>
    </div>

    <form method="POST" class="admin-form">

        <?= csrf_field() ?>

        <input
            type="hidden"
            name="id"
            value="<?= e((string)($edit['id'] ?? 0)) ?>"
        >

        <label>Degree</label>

        <input
            type="text"
            name="degree"
            required
            value="<?= e($edit['degree'] ?? '') ?>"
        >

        <label>Institution</label>

        <input
            type="text"
            name="institution"
            required
            value="<?= e($edit['institution'] ?? '') ?>"
        >

        <label>Period</label>

        <input
            type="text"
            name="period"
            value="<?= e($edit['period'] ?? '') ?>"
        >

        <label>Description</label>

        <textarea
            name="description"
            rows="5"
        ><?= e($edit['description'] ?? '') ?></textarea>

        <label>Sort Order</label>

        <input
            type="number"
            name="sort_order"
            value="<?= e((string)($edit['sort_order'] ?? 0)) ?>"
        >

        <button class="admin-btn">
            <?= $edit ? 'Update Education' : 'Add Education' ?>
        </button>

    </form>


    <div class="admin-table-wrap">

        <table class="admin-table">

            <thead>
                <tr>
                    <th>Degree</th>
                    <th>Institution</th>
                    <th>Period</th>
                    <th></th>
                </tr>
            </thead>

            <tbody>

            <?php foreach ($items as $item): ?>

                <tr>

                    <td><?= e($item['degree']) ?></td>
                    <td><?= e($item['institution']) ?></td>
                    <td><?= e($item['period']) ?></td>

                    <td class="actions">

                        <a href="?edit=<?= $item['id'] ?>">
                            Edit
                        </a>

                        <a
                            href="?delete=<?= $item['id'] ?>"
                            onclick="return confirm('Delete this education?')"
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