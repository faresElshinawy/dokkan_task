<script src="{{ asset('assets') }}/vendor/libs/jquery/jquery.js"></script>


@yield('js')

<script>
    $(document).ready(function() {
        var channel = Echo.private("create-album.{{ Auth::user()->id }}")
        channel.listen('.create-album', function(data) {
            let html = `<x-dropdown-link>
                                You Have Created This New Album ${data.data.album_name}
                            </x-dropdown-link>`;
            $('.alert-holder').remove();
            $('.alert-box-content').prepend(html);
        });
    });
</script>
