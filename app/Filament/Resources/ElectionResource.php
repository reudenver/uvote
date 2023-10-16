<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use App\Models\Election;
use App\Models\Position;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\DateTimePicker;
use App\Filament\Resources\ElectionResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ElectionResource\RelationManagers;

class ElectionResource extends Resource
{
    protected static ?string $model = Election::class;

    protected static ?string $navigationIcon = 'heroicon-o-bolt';

    protected static ?int $navigationSort = 8;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()
                    ->schema([
                        Section::make('Election Details')
                            ->schema([
                                Select::make('organization_id')
                                    ->label('Organization')
                                    ->relationship('organization', 'name')
                                    ->rules('required')
                                    ->columnSpanFull(),

                                DateTimePicker::make('start')
                                    ->label('Start')
                                    ->seconds(false)
                                    ->default(now())
                                    ->minDate(now())
                                    ->rules('required'),

                                DateTimePicker::make('end')
                                    ->label('End')
                                    ->seconds(false)
                                    ->default(now())
                                    ->minDate(now())
                                    ->afterOrEqual('start')
                                    ->rules('required')
                            ])->columnSpan(2)->columns(2),

                        Section::make()
                            ->schema([
                                Repeater::make('candidates')
                                    ->schema([
                                        Select::make('position')
                                            ->options(Position::all()->pluck('name', 'id'))
                                            ->required(),
                                        Select::make('candidate_name')
                                            ->options(User::all()->pluck('name', 'id'))
                                            ->searchable()
                                            ->required()
                                            ->unique(Election::class, 'candidates')
                                    ])
    ->columns(2)
                            ]),
                    ])
                    ->columnSpan(2)->columns(2),

                Group::make()
                    ->schema([

                        Section::make('Voters')
                            ->collapsible()
                            ->collapsed(true)
                            ->schema([
                                CheckboxList::make('courses')
                                    ->label('Availble to')
                                    ->searchable()
                                    ->relationship('courses', 'name')
                                    ->bulkToggleable(),
                            ])->columnSpan(1)
                    ]),


            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('organization.name')
                    ->label('Organization')
                    ->searchable(),
                
                TextColumn::make('start')
                    ->label('Start')
                    ->dateTime('F d, Y H:i A')
                    ->searchable(),

                TextColumn::make('end')
                    ->label('End')
                    ->dateTime('F d, Y H:i A')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListElections::route('/'),
            'create' => Pages\CreateElection::route('/create'),
            'edit' => Pages\EditElection::route('/{record}/edit'),
        ];
    }    
}
