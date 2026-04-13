<!DOCTYPE html>
<html>
<head>
    <title>Employees</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">

    

    <?php if(session('success')): ?>
        <div class="alert alert-success"><?php echo e(session('success')); ?></div>
    <?php endif; ?>

    <!-- Filters -->
    <form method="GET" action="<?php echo e(url('/employees')); ?>" class="row g-2 mb-3">
        <div class="col-md-3">
            <input type="text" name="search" class="form-control form-control-sm"
                placeholder="Search by Name" value="<?php echo e(request('search')); ?>">
        </div>
        <div class="col-md-2">
            <select name="department_id" class="form-select form-select-sm">
                <option value="">All Departments</option>
                <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dept): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($dept->id); ?>" <?php echo e(request('department_id') == $dept->id ? 'selected' : ''); ?>>
                        <?php echo e($dept->name); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="col-md-2">
            <select name="manager_id" class="form-select form-select-sm">
                <option value="">All Managers</option>
                <?php $__currentLoopData = $managers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mgr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($mgr->id); ?>" <?php echo e(request('manager_id') == $mgr->id ? 'selected' : ''); ?>>
                        <?php echo e($mgr->full_name); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="col-md-2">
            <input type="date" name="date_from" class="form-control form-control-sm" value="<?php echo e(request('date_from')); ?>">
        </div>
        <div class="col-md-2">
            <input type="date" name="date_to" class="form-control form-control-sm" value="<?php echo e(request('date_to')); ?>">
        </div>
        <div class="col-auto">
            <button class="btn btn-primary btn-sm">Filter</button>
            <a href="<?php echo e(url('/employees')); ?>" class="btn btn-secondary btn-sm">Clear</a>
        </div>
    </form>

    <div class="row">
        <!-- Employee Table -->
        <div class="col-md-8">
            <table class="table table-bordered table-sm">
                <thead class="table-light">
                    <tr>
                        <th>Name</th>
                        <th>Code</th>
                        <th>Department</th>
                        <th>Manager</th>
                        <th>Joining</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($emp->full_name); ?></td>
                        <td><?php echo e($emp->employee_code); ?></td>
                        <td><?php echo e($emp->department?->name ?? '—'); ?></td>
                        <td><?php echo e($emp->manager?->full_name ?? '—'); ?></td>
                        <td><?php echo e($emp->joining_date); ?></td>
                        <td>
                            <button class="btn btn-warning btn-sm"
                                onclick="editEmployee(<?php echo e($emp->id); ?>)">Edit</button>
                            <form method="POST" action="<?php echo e(url('/employees/' . $emp->id)); ?>" class="d-inline"
                                onsubmit="return confirm('Delete this employee?')">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="6" class="text-center text-muted">No employees found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <?php echo e($employees->links()); ?>

        </div>

        <!-- Add / Edit Employee -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title" id="form-title">Add Employee</h5>

                    <?php if($errors->any()): ?>
                        <div class="alert alert-danger py-1"><?php echo e($errors->first()); ?></div>
                    <?php endif; ?>

                    <form method="POST" id="emp-form" action="<?php echo e(url('/employees')); ?>">
                        <?php echo csrf_field(); ?>
                        <span id="method-field"></span>

                        <div class="mb-2">
                            <input type="text" name="full_name" id="full_name" class="form-control form-control-sm"
                                placeholder="Full Name" value="<?php echo e(old('full_name')); ?>" required>
                        </div>
                        <div class="mb-2">
                            <input type="text" name="employee_code" id="employee_code" class="form-control form-control-sm"
                                placeholder="Employee Code" value="<?php echo e(old('employee_code')); ?>" required>
                        </div>
                        <div class="mb-2">
                            <select name="department_id" id="department_id" class="form-select form-select-sm" required>
                                <option value="">Select Department</option>
                                <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dept): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($dept->id); ?>"><?php echo e($dept->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="mb-2">
                            <select name="manager_id" id="manager_id" class="form-select form-select-sm">
                                <option value="">Select Manager</option>
                                <?php $__currentLoopData = $managers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mgr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($mgr->id); ?>"><?php echo e($mgr->full_name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="mb-2">
                            <input type="date" name="joining_date" id="joining_date" class="form-control form-control-sm"
                                value="<?php echo e(old('joining_date')); ?>" required>
                        </div>
                        <div class="mb-2">
                            <input type="email" name="email" id="email" class="form-control form-control-sm"
                                placeholder="Email" value="<?php echo e(old('email')); ?>">
                        </div>
                        <div class="mb-2">
                            <input type="text" name="phone" id="phone" class="form-control form-control-sm"
                                placeholder="Phone" value="<?php echo e(old('phone')); ?>">
                        </div>

                        <div class="d-flex gap-2">
                            <button class="btn btn-primary btn-sm" type="submit">Save Employee</button>
                            <button class="btn btn-secondary btn-sm" type="button" onclick="resetForm()">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function editEmployee(id) {
    fetch('<?php echo e(url('/employees')); ?>/' + id + '/edit')
        .then(r => r.json())
        .then(emp => {
            document.getElementById('form-title').textContent = 'Edit Employee';
            document.getElementById('full_name').value = emp.full_name;
            document.getElementById('employee_code').value = emp.employee_code;
            document.getElementById('department_id').value = emp.department_id;
            document.getElementById('manager_id').value = emp.manager_id ?? '';
            document.getElementById('joining_date').value = emp.joining_date;
            document.getElementById('email').value = emp.email ?? '';
            document.getElementById('phone').value = emp.phone ?? '';
            document.getElementById('emp-form').action = '<?php echo e(url('/employees')); ?>/' + id;
            document.getElementById('method-field').innerHTML = '<input type="hidden" name="_method" value="PUT">';
        });
}

function resetForm() {
    document.getElementById('form-title').textContent = 'Add Employee';
    document.getElementById('emp-form').reset();
    document.getElementById('emp-form').action = '<?php echo e(url('/employees')); ?>';
    document.getElementById('method-field').innerHTML = '';
}
</script>
</body>
</html>
<?php /**PATH C:\laragon\www\employee-app\resources\views/employees/index.blade.php ENDPATH**/ ?>