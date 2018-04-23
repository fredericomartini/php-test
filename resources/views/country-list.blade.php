<table class="table table-striped table-bordered dataTable">
    <thead>
    <tr>
        <th>Country Code</th>
        <th>Contry Name</th>
    </tr>
    </thead>
    <tbody>
    @forelse($countryList as $code => $name)
        <tr>
            <td> {{$code}} </td>
            <td> {{$name}} </td>
        </tr>
    @empty
    @endforelse
    </tbody>
</table>

<script>
    if (!$.fn.DataTable.isDataTable('.dataTable')) {
        $('.dataTable').DataTable({
            paging: true,
            lengthChange: true,
            searching: true,
            ordering: true,
            info: true,
            autoWidth: false,
            pageLength: 10
        });
    }
</script>
