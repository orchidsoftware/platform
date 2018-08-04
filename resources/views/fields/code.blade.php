@component('platform::partials.fields.group',get_defined_vars())
@php
    unset ($attributes['value']);
@endphp
    <style>
        .code pre {
            background: none;
        }

        .codeflask__flatten{
            padding: 10px!important;
            line-height: 20px!important;
            white-space: pre!important;
            overflow: auto!important;
            margin: 0 !important;
            text-align: left!important;
        }

        .codeflask.codeflask--has-line-numbers:before{
            background: #f8f9fa;
        }

        </style>

    <div
            data-controller="fields--code"
            data-fields--code-language="{{$language}}"
            data-fields--code-line-numbers="{{$lineNumbers}}"
            data-fields--code-default-Theme="{{$defaultTheme}}"
    >
        <div class="code b" style="
        position: relative;
        width: 100%;
        min-height: 300px;"></div>
        <input @if ($language=='json') value="{{json_encode($value)}}" @else value="{{$value}}" @endif type="hidden"  @include('platform::partials.fields.attributes', ['attributes' => $attributes])>
    </div>
@endcomponent