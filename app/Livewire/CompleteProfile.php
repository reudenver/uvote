<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Filament\Forms\Form;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Concerns\InteractsWithForms;

class CompleteProfile extends Component implements HasForms
{
    use InteractsWithForms;

    public User $user;
    public ?array $data = [];
    
    public function mount(): void
    {
        $this->user = Auth::user();
        if ($this->user->course_id != null 
        && $this->user->section_id != null
        && $this->user->gender != null) {
            abort(403, 'Oppps! Updated na profile mo :)');
        }
        $this->form->fill([
            'course_id' => $this->user->course_id,
            'section_id' => $this->user->section_id,
            'gender' => $this->user->gender,
            'photo' => $this->user->photo
        ]);
    }
    
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Profile')
                    ->description('Complete your profile to continue')
                    ->schema([
                        Select::make('course_id')
                            ->label('Course')
                            ->relationship('course', 'name')
                            ->required(),

                        Select::make('section_id')
                            ->label('Section')
                            ->relationship('section', 'name')
                            ->required(),

                        Select::make('gender')
                            ->label('Gender')
                            ->options([
                                'm' => 'Male',
                                'f' => 'Female'
                            ])
                            ->required(),

                        FileUpload::make('photo')
                            ->disk('public')
                            ->directory('user-photo')
                            ->image(),

                        
                    ])->columnSpanFull(),
            ])
            ->statePath('data')
            ->model($this->user)
            ->columns(3);
    }

    public function update()
    {
        $data = $this->form->getState();

        $this->user->course_id = $data['course_id'];
        $this->user->section_id = $data['section_id'];
        $this->user->gender = $data['gender'];
        $this->user->photo = $data['photo'];
        $this->user->save();

        session()->flash('message', 'You are now able to begin casting your votes for the options that are accessible to you.');
        return redirect('/');
    }

    public function render(): View
    {
        return view('livewire.complete-profile');
    }
}
