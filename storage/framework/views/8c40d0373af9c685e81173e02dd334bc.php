<!DOCTYPE html>
<html>
<head>
    <title>Managers</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Manager Management</h4>
        <div class="d-flex gap-2">
            <a href="/departments" class="btn btn-outline-secondary btn-sm">Departments</a>
            <a href="/employees" class="btn btn-outline-primary btn-sm">← Employees</a>
        </div>
    </div>

    <?php if(session('success')): ?>
        <div class="alert alert-success py-2"><?php echo e(session('success')); ?></div>
    <?php endif; ?>

    <div class="row">
        <!-- Manager List -->
        <div class="col-md-8">
            <table class="table table-bordered table-sm">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Department</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $managers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mgr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($managers->firstItem() + $loop->index); ?></td>
                        <td><?php echo e($mgr->name); ?></td>
                        <td><?php echo e($mgr->email ?? '—'); ?></td>
                        <td><?php echo e($mgr->phone ?? '—'); ?></td>
                        <td><?php echo e($mgr->department?->name ?? '—'); ?></td>
                        <td>
                            <button class="btn btn-warning btn-sm"
                                onclick="editMgr(<?php echo e($mgr->id); ?>, '<?php echo e(addslashes($mgr->name)); ?>', '<?php echo e($mgr->email); ?>', '<?php echo e($mgr->phone); ?>', '<?php echo e($mgr->department_id); ?>')">
                                Edit
                            </button>
                            <form method="POST" action="/managers/<?php echo e($mgr->id); ?>" class="d-inline"
                                onsubmit="return confirm('Delete this manager?')">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="6" class="text-center text-muted">No managers found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <?php echo e($managers->links()); ?>

        </div>

        <!-- Add / Edit Manager -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title" id="form-title">Add Manager</h5>

                    <?php if($errors->any()): ?>
                        <div class="alert alert-danger py-1"><?php echo e($errors->first()); ?></div>
                    <?php endif; ?>

                    <form method="POST" id="mgr-form" action="/managers">
                        <?php echo csrf_field(); ?>
                        <span id="method-field"></span>

                        <div class="mb-2">
                            <label class="form-label form-label-sm">Name</label>
                            <input type="text" name="name" id="mgr-name" class="form-control form-control-sm"
                                value="<?php echo e(old('name')); ?>" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label form-label-sm">Email</label>
                            <input type="email" name="email" id="mgr-email" class="form-control form-control-sm"
                                value="<?php echo e(old('email')); ?>">
                        </div>
                        <div class="mb-2">
                            <label class="form-label form-label-sm">Phone</label>
                            <input type="text" name="phone" id="mgr-phone" class="form-control form-control-sm"
                                value="<?php echo e(old('phone')); ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label form-label-sm">Department</label>
                            <select name="department_id" id="mgr-dept" class="form-select form-select-sm">
                                <option value="">Select Department</option>
                                <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dept): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($dept->id); ?>"><?php echo e($dept->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="d-flex gap-2">
                            <button class="btn btn-primary btn-sm" type="submit">Save</button>
                            <button class="btn btn-secondary btn-sm" type="button" onclick="resetForm()">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function editMgr(id, name, email, phone, deptId) {
    document.getElementById('form-title').textContent = 'Edit Manager';
    document.getElementById('mgr-name').value  = name;
    document.getElementById('mgr-email').value = email;
    document.getElementById('mgr-phone').value = phone;
    document.getElementById('mgr-dept').value  = deptId;
    document.getElementById('mgr-form').action = '/managers/' + id;
    document.getElementById('method-field').innerHTML = '<input type="hidden" name="_method" value="PUT">';
    window.scrollTo(0, 0);
}

function resetForm() {
    document.getElementById('form-title').textContent = 'Add Manager';
    document.getElementById('mgr-form').reset();
    document.getElementById('mgr-form').action = '/managers';
    document.getElementById('method-field').innerHTML = '';
}
</script>
</body>
</html>
<?php /**PATH C:\laragon\www\employee-app\resources\views/managers/index.blade.php ENDPATH**/ ?>