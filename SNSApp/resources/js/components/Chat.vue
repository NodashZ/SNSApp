<template>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form @submit.prevent="onsubmit_Form()">
                        <div class="input-group mt-1">
                            <input type="text" class="form-control" placeholder="メッセージ" aria-describedby="button-addon2"
                                v-on:input="commentStr = $event.target.value">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="submit" id="button-addon2">送信</button>
                            </div>
                        </div>
                    </form>

                    <ul class="list-disc" v-for="message in messages">
                        <li><strong>{{message.user}}</strong>
                            <div>{{message.message}}</div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Axios from 'axios'

export default {
    data() {
        return {
            commentStr: String,
            messages:[],
        };
    },
    created() {
        window.Echo.private('chat')
            .listen('MessageSent', (e) => {
                this.messages.push({
                    message: e.message.body,
                    user: e.message.username
                });
            });
    },
    computed: {

    },
    methods: {
        onsubmit_Form() {
            if (!this.commentStr) {
                return;
            }

            let params = { 'message': this.commentStr };

            Axios.post('/api/chat', params)
                .then(response => {
                    console.log(response);
                })
                .catch(error => {
                    alert(error.response)
                    console.log(error.response)
                });
        },

    }
}

</script>