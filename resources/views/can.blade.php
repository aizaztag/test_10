@if(auth()->user()->hasRole('admin'))
    {{-- Display content only for users with 'admin' role --}}
    <p>Welcome, Admin!</p>
@endif
