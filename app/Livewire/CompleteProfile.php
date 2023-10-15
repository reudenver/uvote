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
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DatePicker;
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
            'photo' => $this->user->photo,
            'birthday' => $this->user->birthday,
            'party_list_id' => $this->user->party_list_id,
            'address' => $this->user->address,
            'organizational_affiliation' => $this->user->organizational_affiliation,
            'notable_achievements' => $this->user->notable_achievements,
            'platform' => $this->user->platform
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

                Section::make('Additional Information')
                    ->description('When seeking election candidacy, please ensure that you provide all the necessary additional profile information below.')
                    ->schema([
                        Select::make('party_list_id')
                            ->label('Partylist')
                            ->relationship('party_list', 'name')
                            ->nullable(),
                        DatePicker::make('birthday'),
                        Textarea::make('address')
                            ->columnSpanFull(),
                        Textarea::make('organizational_affiliation')
                            ->columnSpanFull(),
                        Textarea::make('notable_achievements')
                            ->columnSpanFull(),
                        Textarea::make('platform')
                            ->columnSpanFull(),
                    ])
                ->columnSpanFull()
                ->collapsible()
                ->collapsed()
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
        $this->user->party_list_id = $data['party_list_id'];
        $this->user->birthday = $data['birthday'];
        $this->user->address = $data['address'];
        $this->user->organizational_affiliation = $data['organizational_affiliation'];
        $this->user->notable_achievements = $data['notable_achievements'];
        $this->user->platform = $data['notable_achievements'];
        $this->user->save();

        session()->flash('message', 'You are now able to begin casting your votes for the options that are accessible to you.');
        return redirect('/');
    }

    public function render(): View
    {
        return view('livewire.complete-profile');
    }
}
