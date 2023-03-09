<template>
    <div class="row justify-content-center mt-5">
        <div class="col-12">
            <div class="card shadow  text-white bg-dark">
                <div class="card-header">Coding Challenge - Network connections</div>
                <div class="card-body">
                    <!-- <div class="btn-group w-100 mb-3" role="group" aria-label="Basic radio toggle button group"> -->
                        <!-- <input type="radio" class="btn-check" name="btnradio" data-toggle="tab" href="#personal" role="tab" aria-selected="true" autocomplete="off" checked>
                        <label class="btn btn-outline-primary" for="btnradio1" id="get_suggestions_btn">Suggestions ()</label>

                        <input type="radio" class="btn-check" name="btnradio" id="btnradio2" autocomplete="off">
                        <label class="btn btn-outline-primary" for="btnradio2" id="get_sent_requests_btn">Sent Requests ()</label>

                        <input type="radio" class="btn-check" name="btnradio" id="btnradio3" autocomplete="off">
                        <label class="btn btn-outline-primary" for="btnradio3" id="get_received_requests_btn">Received Requests()</label>

                        <input type="radio" class="btn-check" name="btnradio" id="btnradio4" autocomplete="off">
                        <label class="btn btn-outline-primary" for="btnradio4" id="get_connections_btn">Connections ()</label> -->
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#get_suggestions_btn" type="button" role="tab" aria-controls="home" aria-selected="true">Suggestions ({{ suggestionsCount }})</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="profile-tab" @click="getSentRequests()" data-bs-toggle="tab" data-bs-target="#get_sent_requests_btn" type="button" role="tab" aria-controls="profile" aria-selected="false">Sent Requests ({{ sentRequestsCount }})</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="contact-tab" @click="getReceivedRequests()" data-bs-toggle="tab" data-bs-target="#get_received_requests_btn" type="button" role="tab" aria-controls="contact" aria-selected="false">Received Requests({{ receivedRequestsCount }})</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="contact-tab" @click="getConnections()" data-bs-toggle="tab" data-bs-target="#get_connections_btn" type="button" role="tab" aria-controls="contact" aria-selected="false">Connections ({{ connectionsCount }})</button>
                            </li>
                        </ul>
                        <div class="tab-content mt-4" id="myTabContent">
                            <div class="tab-pane fade show active" id="get_suggestions_btn" role="tabpanel" aria-labelledby="home-tab">
                                <div class="d-flex justify-content-between">
                                    <table class="ms-1">
                                        <tr v-for="user in suggestions" :key="user.id">
                                            <td class="align-middle">{{ user.name }}</td>
                                            <td class="align-middle"> - </td>
                                            <td class="align-middle">{{ user.email }}</td>
                                            <td class="text-right">
                                                <button :id="'connect_btn_'+user.id" class="btn btn-primary me-1" @click="connect(user.id)">Connect</button>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="d-flex justify-content-center mt-2 py-3" id="load_more_btn_parent" v-if="suggestions.length == 10">
                                    <button class="btn btn-primary" @click="getSuggestions()" id="suggestion_more_btn">Load more</button>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="get_sent_requests_btn" role="tabpanel" aria-labelledby="profile-tab">
                                <template v-if="sentRequests.length == 0">
                                    <div id="connections_in_common_skeleton" class="{{-- d-none --}}">
                                        <br>
                                        <span class="fw-bold text-white">Loading Skeletons</span>
                                        <div class="px-2" v-for="index in 10" :key="index">
                                            <x-skeleton />
                                        </div>
                                    </div>
                                </template>
                                <template v-else>
                                    <div class="d-flex justify-content-between">
                                        <table class="ms-1" v-if="sentRequests">
                                            <tr v-for="item in sentRequests" :key="item.id">
                                                <td class="align-middle">{{ item.receiver.name }}</td>
                                                <td class="align-middle"> - </td>
                                                <td class="align-middle">{{ item.receiver.email }}</td>
                                                <td>
                                                    <button id="accept_request_btn_" class="btn btn-primary me-1" @click="withdrawRequest(item.id)">Withdraw Request</button>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="d-flex justify-content-center mt-2 py-3" id="load_more_btn_parent" v-if="sentRequests.length > 10">
                                        <button class="btn btn-primary" @click="getSentRequests()" id="suggestion_more_btn">Load more</button>
                                    </div>
                                </template>
                            </div>
                            <div class="tab-pane fade" id="get_received_requests_btn" role="tabpanel" aria-labelledby="contact-tab">
                                <div class="d-flex justify-content-between">
                                    <table class="ms-1" v-if="receivedRequests">
                                        <tr v-for="item in receivedRequests" :key="item.id">
                                            <td class="align-middle">{{ item.sender.name }}</td>
                                            <td class="align-middle"> - </td>
                                            <td class="align-middle">{{ item.sender.email }}</td>
                                            <td>
                                                <button id="accept_request_btn_" class="btn btn-primary me-1" @click="acceptRequest(item.id)">Accept</button>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="get_connections_btn" role="tabpanel" aria-labelledby="contact-tab">
                                <div class="d-flex justify-content-between">
                                    <table class="ms-1" v-if="connections">
                                        <tr v-for="item in connections" :key="item.id">
                                            <td class="align-middle">{{ item.receiver.name }}</td>
                                            <td class="align-middle"> - </td>
                                            <td class="align-middle">{{ item.receiver.email }}</td>
                                            <td>
                                                <button id="accept_request_btn_" class="btn btn-primary me-1" @click="acceptRequest(item.id)">Connections in Common</button>
                                                <button id="accept_request_btn_" class="btn btn-primary me-1" @click="removeConnection(item.id)">Remove Connection</button>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    <!-- </div> -->
                </div>                    
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props:['users', 'lastSuggestionId', 'suggestionsCount', 'sentRequestsCount', 'receivedRequestsCount', 'connectionsCount'],
        data(){
            return{
                connections: [],
                lastConnection: null,
                suggestions: [],
                lastSuggestion: null,
                sentRequests: [],
                lastSentRequest: null,
                receivedRequests: [],
                lastReceivedRequest: null,
            }
        },
        mounted(){
            console.log(this.lastSuggestion, this.lastSuggestionId);
            this.lastSuggestion = this.lastSuggestionId;
            this.suggestions = this.users;
            console.log(this.lastSuggestion);
        },
        methods: {
            getSuggestions(){
                const axios = require('axios').default;
                axios
                .get(`/suggestions?last_id=${this.lastSuggestion}`)
                .then(response => {
                    if(response.data.success){
                        this.suggestions.push(...response.data.suggestions);
                        if(response.data.lastSuggestionId == null){
                            document.getElementById('suggestion_more_btn').style.display = 'none';
                        }
                    }
                })
                .catch(error => {
                    console.log(error);
                });
            },
            getSentRequests(){
                const axios = require('axios').default;
                axios
                .get(`/sent-requests?last_id=${this.lastSentRequest}`)
                .then(response => {
                    if(response.data.success){
                        this.sentRequests.push(...response.data.sentRequests);
                        this.lastSentRequest = response.data.lastSentRequestId
                    }
                })
                .catch(error => {
                    console.log(error);
                });
            },
            getReceivedRequests(){
                axios
                .get('/received-requests')
                .then(response => {
                    if(response.data.success){
                        this.receivedRequests = response.data.receivedRequests;
                    }
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            acceptRequest(id){
                const axios = require('axios').default;
                axios
                .get('/accept-request/' + id)
                .then(response => {
                    if(response.data.success){
                        console.log('request withdrawn!');
                    }
                })
                .catch(error => {
                    console.log(error);
                });
            },
            withdrawRequest(id){
                const axios = require('axios').default;
                axios
                .get('/withdraw-request/' + id)
                .then(response => {
                    if(response.data.success){
                        console.log('request withdrawn!');
                    }
                })
                .catch(error => {
                    console.log(error);
                });
            },
            getConnections(){
                axios.get('/connections')
                .then(response => {
                    if(response.data.success){
                        this.connections = response.data.connections;
                    }
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            removeConnection(id){
                axios.get('/connection/remove/' + id)
                .then(response => {
                    if(response.data.success){
                        console.log('connection removed');
                    }
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            connect(id){
                var acceptBtn = document.getElementById(`connect_btn_${id}`);
                console.log('acceptBtn', acceptBtn);
                acceptBtn.innerHTML = "Processing...";
                axios.post('/connection/store', {
                    id: id,
                })
                .then(response => {
                    if(response.data.success){
                        acceptBtn.blur();
                        acceptBtn.innerHTML = "Request sent";
                        console.log('Connection sent successfully');
                    }
                })
                .catch(function (error) {
                    console.log(error);
                });
            }
        }
    }

</script>