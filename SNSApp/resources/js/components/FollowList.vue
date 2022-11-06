<template>
    <div>
        <post-message title='ユーザー一覧' content=""> </post-message>

        <table class="table table-striped">
            <tr>
                <th>ユーザー名</th>
                <th></th>
                <th></th>
            </tr>
            <tr v-for="user in users">
                <td>{{user.name }}</td>
                <td>{{isFollwerStr(user) }}</td>
                <td v-if="isfollow(user)">
                    <button type="button" class="btn btn-success"
                        @click="unfollow(user.id)">フォロー解除</button>
                </td>
                <td v-else>
                    <button type="button" class="btn btn-secondary"
                        @click="follow(user.id)">フォローする</button>
                </td>
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
            curUser: {},
        };
    },
    created() {
        this.fetchUsers()
    },
    computed: {
        
    },
    methods: {
        isfollow(user) {
            let curId = this.curUser.id
            let retVal = false
            //  alert(JSON.stringify(user.followers))
            if (user.followers) {
                user.followers.forEach(user => {
                    if (user.id == curId) {
                        retVal = true
                    }
                });
            }
            return retVal
        },
        isFollwerStr(user){
            let curId = this.curUser.id
            let retVal = "フォローされていません"
            //  alert(JSON.stringify(user.followers))
            if (user.follows) {
                user.follows.forEach(user => {
                    if (user.id == curId) {
                        retVal = "フォローされています"
                    }
                });
            }
            return retVal
        },
        follow(userId) {
            let url = `/api/follow/${userId}`
            Axios.post(url)
                .then(Response => {
                    this.fetchUsers()
                })
                .catch(error => { alert(error) })
        },
        unfollow(userId) {
            let url = `/api/unfollow/${userId}`
            Axios.delete(url)
                .then(Response => {
                    this.fetchUsers()
                })
                .catch(error => { alert(error) })
        },
        fetchUsers() {
            Axios.get("/api/users", {
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
        
    }
}

</script>