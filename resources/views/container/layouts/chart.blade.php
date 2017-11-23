<div class="bg-white">
        <div class="wrapper">
            <div class="row">

                <div id="{{$slug}}"></div>
            </div>
        </div>
</div>
<script>
document.addEventListener("turbolinks:load", function() {


    var data = {
        labels: ["12am-3am", "3am-6am", "6am-9am", "9am-12pm",
            "12pm-3pm", "3pm-6pm", "6pm-9pm", "9pm-12am"],

        datasets: [
            {
                title: "Some Data",
                values: [25, 40, 30, 35, 8, 52, 17, -4]
            },
            {
                title: "Another Set",
                values: [25, 50, -10, 15, 18, 32, 27, 14]
            },
            {
                title: "Yet Another",
                values: [15, 20, -3, -15, 58, 12, -17, 37]
            }
        ]
    };

    new Chart({
        parent: "#{{$slug}}",
        title: "{{$title}}",
        data: data,
        type: '{{$type}}',
        height: '{{$height}}',

        colors: ['#212529', '#c92a2a', '#a61e4d', '#862e9c', '#5f3dc4', '#364fc7', '#1862ab', '#0b7285', '#087f5b', '#2b8a3e', '#5c940d', '#e67700', '#d9480f'],
    });


});

</script>
