<div>
    <!-- An unexamined life is not worth living. - Socrates --> 
    <!-- notice board view -->
    {{ $title }}
    <a href="{{ url( 'notices/create')}}">Create New Notice</a>

    <!-- {{ $notices }} -->
        <table border="1">
            <tr>
                <th>id</th>
                <th>title</th>
                <th>description</th>
                <th>date of Publ</th>
                <th>image</th>                
                <th>date of expire</th>
                <th>Active</th>
                <th>action</th>
            </tr>

            @foreach($notices as $notice)          
                <tr>
                    <td>{{ $notice->id }}</td>
                    <td>{{ $notice->title }}</td>
                    <td>{{ $notice->desc }}</td>
                    <td>{{ $notice->dop }}</td>                    
                    <td>{{ $notice->fileaddr }}
                        <img src="{{ url( $notice->fileaddr )}}" width="120px" />
                    </td>
                    <td>{{ $notice->doe }}</td>
                    <td>{{ $notice->is_active }}</td>
                    <td>{{ $notice->id }}
                        <a href="{{ url( 'notices/' . $notice->id . '')}}">Show</a>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>