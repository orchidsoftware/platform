<div class="bg-white">
        <div class="wrapper">
            <div class="row">

                <div id="{{$slug}}"></div>
            </div>
        </div>
</div>
<script>
document.addEventListener("turbolinks:load", function () {

    new Chart({
        parent: "#{{$slug}}",
        title: "{{$title}}",
        data: {
            labels: JSON.parse('{!! $labels !!}'),
            datasets: JSON.parse('{!! $data !!}')
        },
        type: '{{$type}}',
        height: '{{$height}}',

        colors: ['#212529', '#c92a2a', '#a61e4d', '#862e9c', '#5f3dc4', '#364fc7', '#1862ab', '#0b7285', '#087f5b', '#2b8a3e', '#5c940d', '#e67700', '#d9480f'],
    });


});

</script>
