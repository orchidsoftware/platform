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

        colors: [
            '#d0dff9',
            '#a3c3f9',
            '#7da1dd',
            '#5580c7',
            '#2860bd',
            '#0a3f98',
            '#062457',
            '#0c182c',
        ],
    });


});

</script>
