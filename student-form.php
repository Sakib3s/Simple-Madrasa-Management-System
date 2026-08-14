<?php if ($errors): ?><div class="mb-5 rounded-lg bg-red-50 p-4 text-sm text-red-700"><?= e(implode(' ', $errors)) ?></div><?php endif; ?>
<form method="post" class="max-w-4xl rounded-xl bg-white p-5 shadow-sm sm:p-6">
    <div class="grid gap-5 md:grid-cols-2">
        <?php foreach ([['student_id','Student ID'],['name','Student Name'],['father_name','Father Name'],['phone','Phone'] ] as [$field,$label]): ?><label class="text-sm font-medium"><?= e($label) ?><input name="<?= e($field) ?>" value="<?= e($student[$field]) ?>" <?= $field !== 'phone' ? 'required' : '' ?> class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2.5"></label><?php endforeach; ?>
        <label class="text-sm font-medium md:col-span-2">Address<textarea name="address" rows="2" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2.5"><?= e($student['address']) ?></textarea></label>
        <label class="text-sm font-medium">Class<select name="class_id" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2.5"><option value="">Select class</option><?php foreach ($classes as $class): ?><option value="<?= $class['id'] ?>" <?= selected($student['class_id'], $class['id']) ?>><?= e($class['class_name']) ?></option><?php endforeach; ?></select></label>
        <label class="text-sm font-medium">Admission Date<input type="date" name="admission_date" value="<?= e($student['admission_date']) ?>" required class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2.5"></label>
        <label class="text-sm font-medium">Status<select name="status" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2.5"><option <?= selected($student['status'], 'Active') ?>>Active</option><option <?= selected($student['status'], 'Inactive') ?>>Inactive</option></select></label>
    </div>
    <div class="mt-6 flex gap-3"><button class="rounded-lg bg-green-700 px-5 py-2.5 text-sm font-semibold text-white hover:bg-green-800"><?= $title === 'Edit Student' ? 'Update Student' : 'Save Student' ?></button><a href="students.php" class="rounded-lg border px-5 py-2.5 text-sm font-semibold">Cancel</a></div>
</form>
