<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
{{--    <link rel="stylesheet" href="../../../node_modules/bootstrap/dist/css/bootstrap.css">--}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous"></head>
<body>

<div class="table-responsive">
    <table class="table table-hover align-middle">
        <thead class="bg-primary">
        <tr class="text-white">
            <th class="text-nowrap">#</th>
            <th class="text-nowrap">{{ 'project_name_label' }}</th>
            <th class="text-nowrap">{{ 'project_logo_label' }}</th>
            <th class="text-nowrap">{{ 'runing_label' }}</th>
            <th class="text-nowrap">{{ 'date_label' }} / {{ 'time_label' }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($projects as $project)
            <tr>
                <td>{{ $project->id }}</td>
                <td>{{ $project->name }}</td>
                <td>
                    <img class="img-fluid rounded-circle" style="width: 50px;" src="{{ public_path()."/storage/img/project/".$project->image->img_path }}" alt="">
                </td>
                <td>
                    <button type="button" class="btn btn-success btn-sm">Active</button>
                </td>
                <td>
                    <div class="">
                        <div class="">
                            <small>
                                <i class="fa-solid fa-calendar text-primary"></i>
                                {{ $project->created_at->format('M D,Y') }}
                            </small>
                        </div>
                        <div class="">
                            <small>
                                <i class="fa-solid fa-clock text-primary"></i>
                                {{ $project->created_at->format('h:i a') }}
                            </small>
                        </div>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
</body>
</html>

