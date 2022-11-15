<template>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form @submit.prevent="onsubmit_Form()">
                        <div class="input-group mt-1">
                            <input id="input_message" type="text" class="form-control" placeholder="メッセージ" aria-describedby="button-addon2"
                                v-on:input="commentStr = $event.target.value" required>
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="submit" id="button-addon2">送信</button>
                            </div>
                        </div>
                    </form>

                    <ul class="list-disc" v-for="message in messages">
                        <div v-if="isMine(message)">
                            <p align="right">
                                <strong>{{message.username}}: </strong>
                                {{message.message}}
                            </p>
                        </div>
                        <div v-else>
                            <p><strong>{{message.username}}: </strong>
                                {{message.message}}
                            </p>
                        </div>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>
<script>

export default {
    data() {
        return {
            commentStr: String,
            messages: [],
            users: [],
            curUser: {},
        };
    },
    created() {
        this.fetchUsers()
        window.Echo.private('chat')
            .listen('MessageSent', (e) => {
                this.messages.push({
                    message: e.message.body,
                    username: e.message.username,
                    userid: e.message.userid
                });
            });
    },
    computed: {
        
    },
    methods: {
        isMine(message){
            return (message.userid == this.curUser.id)
        },
        fetchUsers() {
            axios.get("/api/users", {
                params: {
                    sort: this.sort
                }
            }
            ).then(response => {
                this.users = response.data.data
                this.curUser = response.data.user
            })
                .catch(error => { alert(error) })
        },
        onsubmit_Form() {
            if (!this.commentStr) {
                return;
            }

            let params = { 'message': this.commentStr };

            axios.post('/api/chat', params)
                .then(response => {
                })
                .catch(error => {
                    alert(error)
                    console.log(error.response)
                });

            const elementInputMessage = document.getElementById("input_message");
            elementInputMessage.value = "";
        },

    }
}

</script>