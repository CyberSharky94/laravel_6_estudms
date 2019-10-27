<table class="table table-bordered table-sm table-striped table-hover">
    @if (!empty($student_image))
        <tr>
            <td class="text-center" colspan="2">
                <img src="{{ url('storage/student_images/'.$student_image->si_filename) }}" alt="Picture of {{ $student->stu_name }}">
            </td>
        </tr>
    @endif
    <tr>
        <th>Student Name:</th>
        <td>{{ $student->stu_name }}</td>
    </tr>
    <tr>
        <th>Date of Birth:</th>
        <td>{{ $student->changeDateFormat($student->stu_dob) }}</td>
    </tr>
    <tr>
        <th>Phone Number:</th>
        <td>{{ $student->stu_phone }}</td>
    </tr>
    <tr>
        <th>Current Level:</th>
        <td>{{ $student->class->level->level_name }}</td>
    </tr>
    <tr>
        <th>Current Class:</th>
        <td>{{ $student->class->class_name }}</td>
    </tr>
    <tr>
        <th>Status:</th>
        <td>{{ $student->getStatus() }}</td>
    </tr>
    <tr>
        <th>Created At:</th>
        <td>{{ $student->changeDateTimeFormat($student->created_at) }}</td>
    </tr>
    <tr>
        <th>Updated At:</th>
        <td>{{ $student->changeDateTimeFormat($student->updated_at) }}</td>
    </tr>
</table>

<br>
<table class="table table-bordered table-sm table-striped table-hover">
    <thead>
        <tr>
            <th colspan="4">Previous Classes</th>
        </tr>
        <tr>
            <th>No.</th>
            <th>Year</th>
            <th>Level</th>
            <th>Class</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($student_classes as $student_class)
        <tr>
            <td>{{ ++$i }}</td>
            <td>{{ $student_class->year }}</td>
            <td>{{ $student_class->class->level->level_name }}</td>
            <td>{{ $student_class->class->class_name }}</td>
        </tr>
        @endforeach
    </tbody>
</table>