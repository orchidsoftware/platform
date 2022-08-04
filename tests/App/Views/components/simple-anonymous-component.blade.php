@props(['property1' => null, 'property2' => 'default value'])

<div>
    It is anonymous component with properties:<br/>
    - property1: {{ $property1 ?? 'oops' }}<br/>
    - property2: {{ $property2 ?? 'oops' }}<br/>
</div>
