@extends('layouts.app')

@section('content')
    <div class="container">
        <x-dashboard />
        <h3>IKONIC Coding challenge</h3>
        <connections 
            :users="{{ $users }}"
            :last-suggestion-id="{{ $lastSuggestionId }}"
            :suggestions-count={{ $suggestionsCount }} 
            :sent-requests-count={{ $sentRequestsCount }}
            :received-requests-count={{ $receivedRequestsCount }}
            :connections-count={{ $connectionsCount }}
        />
    </div>
@endsection