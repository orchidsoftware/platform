# 1.2 (dev) (17.09.2017)
- Removing Fields
- Removing Footer
- Removing Shortcut
- Removing summernote
- Remote publication of public files, the location of this is used by the proxy controller 
- Removing submodules (Will be in separate packages):
    - Graphical installation
    - Backups
    - Defender
    - Viewing logs
    - Monitor
    - Robot.txt Editor
    - Scheme
    - UTM Tag Generator
    - View all php settings (Form)
- Added TinyMCE
- Added support fulltext search:
```php
namespace DummyNamespace;

use Orchid\Platform\Behaviors\Many;

class DummyClass extends Many
{

    /**
     * Get the indexable data array for the model.
     *
     * @param $array
     *
     * @return mixed
     */
    public function toSearchableArray($array)
    {
        // Customize array...
    
        return $array;
    }
}

```
- Added attachments any models :

```php
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Orchid\Platform\Core\Traits\Attachment;

class Idea extends Model
{
    use Attachment;
}
```

- Added SPA emulation (turbolinks)
- Added experimental json relation:

```php

$post = Post::find(1);

$post->addJsonRelation('movie',4);

$post->save();

$movie = $post->loadJsonRelation('movie')->get()
```



# 1.1.4 - 1.1.5 (12.09.2017)
- Added events for role assignment and deletion


# 1.1.2 (06.09.2017)
- Fix bug create user
- Removing unused methods
- Move google analytics to widget

# 1.1.1
- Support Laravel 5.5

# 1.1 (31.08.2017)
- fix config display auth
- Added global permission for superadmin
- Summernote supports "media"
- Shortcut (ctrl + s) save form

# 1.0 (04.08.2017)

- Added menu badges & notifications
- Added the ability to insert js and css code
- Unit tests written


- Removing the Content Management System
- Rename config file "content" to "platform"
- Removed auxiliary functions
- Remove unusing fields
- Remove news subscription
