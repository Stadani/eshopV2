<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">
    <title>PixelNexus | Form</title>

    @extends('components/layout')
    @section('listcss')
        <link rel="stylesheet" href="/css/forumStyle.css">
        <link rel="stylesheet" href="/css/postFormStyle.css">
        <link rel="stylesheet" href="/css/gameFormStyle.css">
    @endsection
    {{--    had to link like this because after opening post it doesnt work--}}
    <link rel="icon" type="image/x-icon" href="{{ asset('images/favicon-32x32.png') }}">
    {{--    https://github.com/habibmhamadi/multi-select-tag--}}
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag/dist/css/multi-select-tag.css">
    <script src="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag@2.0.0/dist/js/multi-select-tag.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>


</head>
<body>
@extends('components.navbar')
@section('content')
    <div class="containerGeneral gameForm">
        {{--        INPUT FIELDS--}}
        <form action="{{ isset($game) ? route('update.game', $game) : route('store.game') }}" method="POST"
              enctype="multipart/form-data">
            @csrf
            @if(isset($game))
                @method('PATCH')
            @endif

            <div>
                <label for="name">Name:</label>
                @if(isset($game))
                    <input type="text" id="name" class="searchbarPostForm" name="name"
                           value="{{ old('name', isset($game) ? $game->name : '') }}" placeholder="Title...">
                @else
                    <input type="text" id="name" class="searchbarPostForm" name="name" required
                           value="{{ old('name', isset($game) ? $game->name : '') }}" placeholder="Title...">
                @endif
            </div>

            <div>
                <label for="game_picture">Game Picture URL:</label>
                @if(isset($game) && $game->game_picture)
                    Old picture:
                    <img src="{{ asset('storage/' . $game->game_picture) }}" alt="oldGamePicture" width="100px">
                    <input type="file" name="game_picture" id="game_picture" accept="image/*">
                @else
                    <input type="file" name="game_picture" id="game_picture" accept="image/*" required>
                @endif

            </div>

            <div>
                <label for="release_date">Release Date:</label>
                <input type="date" id="release_date" name="release_date"
                       value="{{ old('release_date', isset($game) ? $game->release_date : '') }}" required>
            </div>

            <div>
                <label for="rating">Rating:</label>
                <input type="number" id="rating" name="rating" min="0" max="5" step="any"
                       value="{{ old('rating', isset($game) ? $game->rating : '') }}" required>
            </div>

            <div>
                <label for="description">Description:</label>
                <textarea id="description" name="description" rows="4"
                          required>{{ old('description', isset($game) ? $game->description : '') }}</textarea>
            </div>

            <div>
                <label for="developers">Developers:</label>
                <select name="developers[]" id="developers" class="specialSelect" multiple>
                    @foreach($developers as $developer)
                        <option
                            value="{{ $developer->id }}" {{ in_array($developer->id, old('developers', isset($game) ? $game->developer->pluck('id')->toArray() : [])) ? 'selected' : '' }}>{{ $developer->name }}</option>
                    @endforeach
                </select>
                <script>
                    new MultiSelectTag('developers')  // id
                </script>
            </div>

            <div>
                <label for="publishers">Publishers:</label>
                <select name="publishers[]" id="publishers" class="specialSelect" multiple>
                    @foreach($publishers as $publisher)
                        <option
                            value="{{ $publisher->id }}" {{ in_array($publisher->id, old('publishers', isset($game) ? $game->publisher->pluck('id')->toArray() : [])) ? 'selected' : '' }}>{{ $publisher->name }}</option>
                    @endforeach
                </select>
                <script>
                    new MultiSelectTag('publishers')  // id
                </script>
            </div>

            <div>

                <label for="trailers">Trailers:</label>
                @if(isset($game) && $game->trailer->isNotEmpty())
                    @foreach($game->trailer as $trailer)
                        <li>{{ $trailer->trailer }}</li>
                    @endforeach
                @endif
                <input type="file" name="trailers[]" id="trailers" accept="video/*" multiple>
            </div>

            <div>
                <label for="screenshots">Screenshots:</label>
                @if(isset($game) && $game->screenshot->isNotEmpty())
                    @foreach($game->screenshot as $screenshot)
                        <li> {{ $screenshot->screenshot }}</li>
                    @endforeach
                @endif
                <input type="file" name="screenshots[]" id="screenshots" accept="image/*" multiple>
            </div>

            <div>
                <label for="genres">Genres:</label>
                <select name="genres[]" id="genres" class="specialSelect" multiple>
                    @foreach($genres as $genre)
                        <option
                            value="{{ $genre->id }}" {{ in_array($genre->id, old('genres', isset($game) ? $game->publisher->pluck('id')->toArray() : [])) ? 'selected' : '' }}>{{ $genre->category }}</option>
                    @endforeach
                </select>
                <script>
                    new MultiSelectTag('genres')  // id
                </script>
            </div>

            <div>
                <label for="platforms">Platform & Price:</label>
                <table id="platformTable">
                    @if(isset($gameAndPlatforms))
                        @foreach($gameAndPlatforms as $index => $gamePlatform)
                            <tr>
                                <td>
                                    <input type="text" name="platforms[]" list="exampleList" class="platformInput"
                                           value="{{ old('platforms.'.$index, $gamePlatform->platform->name ) }}">
                                    <datalist id="exampleList">
                                        @foreach($platforms as $platform)
                                            <option value="{{$platform->name}}">
                                        @endforeach
                                    </datalist>
                                </td>
                                <td>
                                    <input type="number" name="prices[]" step="any"
                                           value="{{ old('prices.'.$index, $gamePlatform->price ?? '') }}">
                                </td>
                                <td>
                                    <button type="button" class="addRow button_bar"><i class="fa-solid fa-plus"></i>
                                    </button>
                                    <button type="button" class="removeRow button_bar"><i class="fa-solid fa-minus"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td>
                                <input type="text" name="platforms[]" list="exampleList" class="platformInput">
                                <datalist id="exampleList">
                                    @foreach($platforms as $platform)
                                        <option value="{{$platform->name}}">
                                    @endforeach
                                </datalist>
                            </td>
                            <td>
                                <input type="number" name="prices[]" step="any">
                            </td>
                            <td>
                                <button type="button" class="addRow button_bar"><i class="fa-solid fa-plus"></i>
                                </button>
                                <button type="button" class="removeRow button_bar"><i class="fa-solid fa-minus"></i>
                                </button>
                            </td>
                        </tr>
                    @endif
                </table>
            </div>

            <div>
                <label for="dlcs">DLCs & Price:</label>
                <table id="dlcsTable">
                    @if(isset($gameAndDlcs))
                        @if($gameAndDlcs->isEmpty())
                            <tr>
                                <td>
                                    <input type="text" name="dlcs[]" class="dlcInput">
                                </td>
                                <td>
                                    <input type="number" name="dlc_prices[]" step="any">
                                </td>
                                <td>
                                    <button type="button" class="addRowDLC button_bar"><i class="fa-solid fa-plus"></i>
                                    </button>
                                    <button type="button" class="removeRowDLC button_bar"><i
                                            class="fa-solid fa-minus"></i>
                                    </button>
                                </td>
                            </tr>

                        @else
                            @foreach($gameAndDlcs as $index => $gameDlc)
                                <tr>
                                    <td>
                                        <input type="text" name="dlcs[]" class="dlcInput"
                                               value="{{ old('platforms.'.$index, $gameDlc->name ?? '') }}">
                                    </td>
                                    <td>
                                        <input type="number" name="dlc_prices[]" step="any"
                                               value="{{ old('dlc_prices.'.$index, $gameDlc->price ?? '') }}">
                                    </td>
                                    <td>
                                        <button type="button" class="addRowDLC button_bar"><i
                                                class="fa-solid fa-plus"></i>
                                        </button>
                                        <button type="button" class="removeRowDLC button_bar"><i
                                                class="fa-solid fa-minus"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    @else
                        <tr>
                            <td>
                                <input type="text" name="dlcs[]" class="dlcInput">
                            </td>
                            <td>
                                <input type="number" name="dlc_prices[]" step="any">
                            </td>
                            <td>
                                <button type="button" class="addRowDLC button_bar"><i class="fa-solid fa-plus"></i>
                                </button>
                                <button type="button" class="removeRowDLC button_bar"><i class="fa-solid fa-minus"></i>
                                </button>
                            </td>
                        </tr>
                    @endif


                </table>
            </div>

            <div>
                <label for="same_series">Games of Same Series:</label>
                <select name="series[]" id="series" class="specialSelect" multiple>
                    @foreach($games as $gameO)
                        <option
                            value="{{ $gameO->id }}" {{ in_array($gameO->id, old('series', isset($game) ? $game->publisher->pluck('id')->toArray() : [])) ? 'selected' : '' }}>{{ $gameO->name }}</option>
                    @endforeach
                </select>
                <script>
                    new MultiSelectTag('series')  // id
                </script>
            </div>

            <div id="serverErrCont">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @error('name')
                <li class="error-message alert alert-danger">{{ $message }}</li>
                @enderror
                @error('game_picture')
                <li class="error-message alert alert-danger">{{ $message }}</li>
                @enderror
                @error('release_date')
                <li class="error-message alert alert-danger">{{ $message }}</li>
                @enderror
                @error('rating')
                <li class="error-message alert alert-danger">{{ $message }}</li>
                @enderror
                @error('description')
                <li class="error-message alert alert-danger">{{ $message }}</li>
                @enderror
                @error('developers')
                <li class="error-message alert alert-danger">{{ $message }}</li>
                @enderror
                @error('publishers')
                <li class="error-message alert alert-danger">{{ $message }}</li>
                @enderror
                @error('trailers')
                <li class="error-message alert alert-danger">{{ $message }}</li>
                @enderror
                @error('screenshots')
                <li class="error-message alert alert-danger">{{ $message }}</li>
                @enderror
                @error('genres')
                <li class="error-message alert alert-danger">{{ $message }}</li>
                @enderror
                @error('platforms')
                <li class="error-message alert alert-danger">{{ $message }}</li>
                @enderror
                @error('prices')
                <li class="error-message alert alert-danger">{{ $message }}</li>
                @enderror
                @error('dlcs')
                <li class="error-message alert alert-danger">{{ $message }}</li>
                @enderror
                @error('dlc_prices')
                <li class="error-message alert alert-danger">{{ $message }}</li>
                @enderror
                @error('series')
                <li class="error-message alert alert-danger">{{ $message }}</li>
                @enderror
            </div>
            <div class="mt-3 mb-3">
                <button type="submit" class="button_bar">Post</button>
            </div>
        </form>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Add Row Button
            document.querySelectorAll('.addRow').forEach(function (button) {
                button.addEventListener('click', function () {
                    var row = this.closest('tr').cloneNode(true);
                    row.querySelector('.platformInput').value = '';
                    row.querySelector('input[type="number"]').value = '';
                    row.querySelectorAll('.addRow, .removeRow').forEach(function (btn) {
                        btn.addEventListener('click', handleButtonClick);
                    });
                    document.getElementById('platformTable').appendChild(row);
                });
            });

            // Remove Row Button
            document.querySelectorAll('.removeRow').forEach(function (button) {
                button.addEventListener('click', handleButtonClick);
            });

            // Function to handle button click for both Add Row and Remove Row buttons
            function handleButtonClick() {
                var row = this.closest('tr');
                if (this.classList.contains('addRow')) {
                    var newRow = row.cloneNode(true);
                    newRow.querySelector('.platformInput').value = '';
                    newRow.querySelector('input[type="number"]').value = '';
                    newRow.querySelectorAll('.addRow, .removeRow').forEach(function (btn) {
                        btn.addEventListener('click', handleButtonClick);
                    });
                    document.getElementById('platformTable').appendChild(newRow);
                } else {
                    if (document.getElementById('platformTable').rows.length > 1) {
                        row.parentNode.removeChild(row);
                    }
                }
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Add Row Button for DLCs
            document.querySelectorAll('.addRowDLC').forEach(function (button) {
                button.addEventListener('click', function () {
                    var row = this.closest('tr').cloneNode(true);
                    row.querySelector('.dlcInput').value = '';
                    row.querySelector('input[type="number"]').value = '';
                    row.querySelectorAll('.addRowDLC, .removeRowDLC').forEach(function (btn) {
                        btn.addEventListener('click', handleButtonClickDLC);
                    });
                    document.getElementById('dlcsTable').appendChild(row);
                });
            });

            // Remove Row Button for DLCs
            document.querySelectorAll('.removeRowDLC').forEach(function (button) {
                button.addEventListener('click', handleButtonClickDLC);
            });

            // Function to handle button click for both Add Row and Remove Row buttons for DLCs
            function handleButtonClickDLC() {
                var row = this.closest('tr');
                if (this.classList.contains('addRowDLC')) {
                    var newRow = row.cloneNode(true);
                    newRow.querySelector('.dlcInput').value = '';
                    newRow.querySelector('input[type="number"]').value = '';
                    newRow.querySelectorAll('.addRowDLC, .removeRowDLC').forEach(function (btn) {
                        btn.addEventListener('click', handleButtonClickDLC);
                    });
                    document.getElementById('dlcsTable').appendChild(newRow);
                } else {
                    if (document.getElementById('dlcsTable').rows.length > 1) {
                        row.parentNode.removeChild(row);
                    }
                }
            }
        });
    </script>
    <x-footer>

    </x-footer>
@endsection
</body>
