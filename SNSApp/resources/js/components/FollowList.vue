<template>
    <div>
        <post-message title='ユーザー一覧' content=""> </post-message>

        <table class="table table-striped">
            <tr>
                <th>ユーザー名</th>
                <th>フォロワー</th>
                <th></th>
                <th></th>
            </tr>
            <tr v-for="user in users">
                <td>{{user.name }}</td>
                <td>{{user.isFollower }}</td>
                <td><button type="button" class="btn btn-primary" @click="editTodo(todo.id)">フォロー</button></td>
                <td><button type="button" class="btn btn-danger" @click="deleteTodo(todo.id)">ブロック</button></td>
            </tr>
        </table>
       
    </div>
</template>
<script>
import Axios from 'axios'

export default {
    data() {
        return {
            users: [],
        };
    },
    created() {
        this.fetchUsers("/api/users")
    },
    computed: {
        
    },
    methods: {
        click() {
            alert("error")
        },
        fetchUsers(url) {
            Axios.get(url, {
                params: {
                    sort: this.sort
                }
            }
            ).then(response => {
                    this.users = response.data.data
                })
                .catch(error => { alert(error) })
        },
    }
}

</script>