<?php

namespace App\Http\Livewire;

use App\Models\File;
use Livewire\Component;
use Livewire\WithFileUploads;

class Uploader extends Component
{
    use WithFileUploads;

    public $files = [];

    protected function validationAttributes()
    {
        return [
            'files.*'=> 'files'
        ];
    }

    public function rules()
    {
        return [
            'files.*'=>['required','file','max:200000']
        ];
    }

    public function updatedFiles($files)
    {
        $this->validateOnly('files.*');

        collect($files)->each(function ($file){
            $name = $file->getClientOriginalName();
            File::create([
                'file-name'=> $name,
                'file-path'=> $file->storeAs('file',$name)

            ]);

        });

        $this->emitTo('uploaded-files','refresh');

    }

    public function render()
    {
        return view('livewire.uploader');
    }
}
