@component($typeForm, get_defined_vars())
    <div class="simplemde-wrapper" data-controller="fields--simplemde">
        <textarea @attributes($attributes)>{{$attributes['value']}}</textarea>
        <input class="d-none upload" type="file" data-action="fields--simplemde#upload">

        <div class="modal fade slide-right" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content-wrapper">
                    <div class="modal-content">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="icon-close p-3 v-center text-lg"></i>
                        </button>
                        <div class="full-height">
                            <div class="modal-body">
                                <div class="p-3">
                                    <h3 class="text-center font-thin">Markdown Guide</h3>
                                    <h4 class="m-b font-thin">Emphasis</h4>
                                    <pre class="p-3">**<strong>bold</strong>**
*<em>italics</em>*
~~<strike>strikethrough</strike>~~</pre>
                                    <h4 class="m-b font-thin">Headers</h4>
                                    <pre class="p-3"># Big header
## Medium header
### Small header
#### Tiny header</pre>
                                    <h4 class="m-b font-thin">Lists</h4>
                                    <pre class="p-3">* Generic list item
* Generic list item
* Generic list item

1. Numbered list item
2. Numbered list item
3. Numbered list item</pre>
                                    <h4 class="m-b font-thin">Links</h4>
                                    <pre class="p-3">[Text to display](http://www.example.com)</pre>
                                    <h4 class="m-b font-thin">Quotes</h4>
                                    <pre class="p-3">&gt; This is a quote.
&gt; It can span multiple lines!</pre>
                                    <h4 class="m-b font-thin">Images &nbsp;
                                        <small>Need to upload an image? <a href="http://imgur.com/"
                                                                           target="_blank" rel="noopener">Imgur</a>
                                            has a great interface.
                                        </small>
                                    </h4>
                                    <pre class="p-3">![](http://www.example.com/image.jpg)</pre>
                                    <h4 class="m-b font-thin">Tables</h4>
                                    <pre class="p-3">| Column 1 | Column 2 | Column 3 |
| -------- | -------- | -------- |
| John     | Doe      | Male     |
| Mary     | Smith    | Female   |

<em>Or without aligning the columns...</em>

| Column 1 | Column 2 | Column 3 |
| -------- | -------- | -------- |
| John | Doe | Male |
| Mary | Smith | Female |
</pre>
                                    <h4 class="m-b font-thin">Displaying code</h4>
                                    <pre class="p-3">`var example = "hello!";`

<em>Or spanning multiple lines...</em>

```
var example = "hello!";
alert(example);
```</pre>
                                    <footer class="text-right">Provided for use with <a
                                            href="http://sparksuite.github.io/simplemde-markdown-editor"
                                            target="_blank">SimpleMDE</a></footer>
                                </div>
                                <div class="p-3">
                                    <button type="button" class="btn btn-default btn-block" data-dismiss="modal">{{__('Cancel')}}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endcomponent
