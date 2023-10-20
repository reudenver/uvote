<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\CheckboxColumn;
use App\Filament\Resources\UserResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UserResource\RelationManagers;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?int $navigationSort = 7;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()
                    ->schema([
                        Section::make('User Details')
                            ->schema([
                                TextInput::make('name')
                                    ->label('Name')
                                    ->rules('required|string')
                                    ->columnSpanFull(),
        
                                TextInput::make('email')
                                    ->label('Email')
                                    ->rules('required|email'),
        
                                TextInput::make('student_id')
                                    ->label('Student ID')
                                    ->rules('required|string'),
        
                                Select::make('course_id')
                                    ->label('Course')
                                    ->relationship('course', 'name')
                                    ->rules('required'),
        
                                Select::make('section_id')
                                    ->label('Section')
                                    ->relationship('section', 'name')
                                    ->rules('required'),
        
                                Select::make('gender')
                                    ->label('Gender')
                                    ->options([
                                        'm' => 'Male',
                                        'f' => 'Female'
                                    ])
                                    ->rules('required'),
        
                                Select::make('is_admin')
                                    ->label('Role')
                                    ->options([
                                        0 => 'Student',
                                        1 => 'Admin'
                                    ])
                                    ->rules('required'),
        
                            ])->columns(2),
        
                        Section::make('Additional Information')
                            ->description('When seeking election candidacy, please ensure to provide all the necessary additional profile information below.')
                            ->schema([
                                Select::make('party_list_id')
                                    ->label('Partylist')
                                    ->relationship('party_list', 'name'),
                                DatePicker::make('birthday'),
                                Textarea::make('address')
                                    ->columnSpanFull(),
                                Textarea::make('organizational_affiliation')
                                    ->columnSpanFull(),
                                Textarea::make('notable_achievements')
                                    ->columnSpanFull(),
                                Textarea::make('platform')
                                    ->columnSpanFull(),
                        ])->columns(2)->collapsible()->collapsed(),
                    ])->columnSpan(2),
                

                Group::make()
                    ->schema([

                        Section::make('Meta')
                            ->schema([
                                FileUpload::make('photo')
                                    ->disk('public')
                                    ->directory('user-photo')
                                    ->image()
                                    ->imageEditor(),
        
                                Toggle::make('is_active')
                                    ->label('Is Active')
                                    ->onIcon('heroicon-m-user')
                                    ->offIcon('heroicon-m-user')
                                    ->onColor('success')
                                    ->offColor('danger')
                                    ->default(true),
                            ]),

                        Section::make()
                            ->schema([
                                TextInput::make('password')
                                    ->password()
                                    ->label('Password')
                                    ->dehydrated(fn ($state) => filled($state)),
                            ])


                    ])->columnSpan(1),

            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Name')
                    ->searchable(),

                TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),

                TextColumn::make('course.name')
                    ->label('Course')
                    ->searchable(),

                TextColumn::make('section.name')
                    ->label('Section')
                    ->searchable(),
            ])
            ->filters([
                // Filter::make('Role')->query(
                //     function (Builder $query) : Builder {
                //         return $query->where('is_admin', true);
                //     } 
                // ),

                SelectFilter::make('is_admin')
                    ->label('Role')
                    ->options([
                        0 => 'Student',
                        1 => 'Admin'
                    ]),

                SelectFilter::make('course_id')
                    ->label('Course')
                    ->relationship('course', 'name'),

                SelectFilter::make('Section_id')
                    ->label('Section')
                    ->relationship('section', 'name'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }
    
    public static function getRelations(): array
    {
        return [
            //
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }    
}
