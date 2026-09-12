<?php
declare(strict_types=1);

require_once __DIR__ . '/../includes/functions.php';

require_admin();

if (isset($_GET['delete'])) {

    db_execute(
        "DELETE FROM projects WHERE id = ?",
        [(int) $_GET['delete']]
    );

    redirect('admin/projects.php');
}

if (is_post()) {

    verify_csrf();

    $id = (int) post('id');

    $data = [
        trim((string) post('title')),
        trim((string) post('category')),
        trim((string) post('description')),
        trim((string) post('technologies')),
        trim((string) post('url')),
        trim((string) post('image')),
        (int) post('sort_order', 0),
        isset($_POST['featured']) ? 1 : 0
    ];

    if ($id > 0) {

        db_execute(
            "UPDATE projects SET
                title=?,
                category=?,
                description=?,
                technologies=?,
                url=?,
                image=?,
                sort_order=?,
                featured=?
             WHERE id=?",
            [...$data, $id]
        );

    } else {

        db_execute(
            "INSERT INTO projects
            (title, category, description, technologies, url,
             image, sort_order, featured)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)",
            $data
        );
    }

    redirect('admin/projects.php');
}

$edit = null;

if (isset($_GET['edit'])) {

    $edit = db_one(
        "SELECT * FROM projects WHERE id=?",
        [(int) $_GET['edit']]
    );
}

$items = db_all(
    "SELECT * FROM projects ORDER BY sort_order, id"
);

$pageTitle = 'Projects';

require_once __DIR__ . '/layout.php';
?>

<div class="admin-content">

    <div class="admin-page-head">
        <div>
            <span>CONTENT</span>
            <h1>Projects</h1>
        </div>
    </div>


    <form method="POST" class="admin-form">

        <?= csrf_field() ?>

        <input
            type="hidden"
            name="id"
            value="<?= e((string)($edit['id'] ?? 0)) ?>"
        >

        <label>Project Title</label>

        <input
            type="text"
            name="title"
            required
            value="<?= e($edit['title'] ?? '') ?>"
        >


        <div class="form-two">

            <div>

                <label>Category</label>

                <input
                    type="text"
                    name="category"
                    value="<?= e($edit['category'] ?? '') ?>"
                >

            </div>

            <div>

                <label>Sort Order</label>

                <input
                    type="number"
                    name="sort_order"
                    value="<?= e((string)($edit['sort_order'] ?? 0)) ?>"
                >

            </div>

        </div>


        <label>Description</label>

        <textarea
            name="description"
            rows="7"
        ><?= e($edit['description'] ?? '') ?></textarea>


        <label>Technologies</label>

        <input
            type="text"
            name="technologies"
            placeholder="PHP, WordPress, JavaScript"
            value="<?= e($edit['technologies'] ?? '') ?>"
        >


        <label>Project URL</label>

        <input
            type="url"
            name="url"
            value="<?= e($edit['url'] ?? '') ?>"
        >


        <label>Image Path</label>

        <input
            type="text"
            name="image"
            value="<?= e($edit['image'] ?? '') ?>"
        >


        <label class="checkbox-label">

            <input
                type="checkbox"
                name="featured"
                <?= !isset($edit['featured']) || $edit['featured'] ? 'checked' : '' ?>
            >

            Featured Project

        </label>


        <button class="admin-btn">
            <?= $edit ? 'Update Project' : 'Add Project' ?>
        </button>

    </form>


    <div class="admin-table-wrap">

        <table class="admin-table">

            <thead>
                <tr>
                    <th>Project</th>
                    <th>Category</th>
                    <th>URL</th>
                    <th></th>
                </tr>
            </thead>

            <tbody>

            <?php foreach ($items as $item): ?>

                <tr>

                    <td>
                        <strong>
                            <?= e($item['title']) ?>
                        </strong>
                    </td>

                    <td>
                        <?= e($item['category']) ?>
                    </td>

                    <td>
                        <?php if ($item['url']): ?>
                            <a
                                href="<?= e($item['url']) ?>"
                                target="_blank"
                            >
                                Visit ↗
                            </a>
                        <?php else: ?>
                            —
                        <?php endif; ?>
                    </td>

                    <td class="actions">

                        <a href="?edit=<?= $item['id'] ?>">
                            Edit
                        </a>

                        <a
                            href="?delete=<?= $item['id'] ?>"
                            onclick="return confirm('Delete this project?')"
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