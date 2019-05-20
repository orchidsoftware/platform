<div
     data-controller="screen--chart"
     data-screen--chart-parent="#{{$slug}}"
     data-screen--chart-title="{{$title}}"
     data-screen--chart-labels="{{$labels}}"
     data-screen--chart-datasets="{{$data}}"
     data-screen--chart-type="{{$type}}"
     data-screen--chart-height="{{$height}}"
     data-screen--chart-options="{{$options}}"
     data-screen--chart-setcolors="{{$setcolors}}"
     data-screen--chart-colors="{{$colors}}"
>
    <div class="row padder-v">
        <div class="pos-rlt w-full">
            <canvas data-target="screen--chart.canvas" id="{{$slug}}" class="w-full h-full"></canvas>
        </div>
    </div>
</div>