<template>
    <div class="container mb-5">
        <div class="row justify-content-center">
            <div class="card">
                <div class="card-header">
                    <div class="row justify-content-between">
                        <div>投稿者: {{ post.userName }}</div>
                        <div v-if="!myPost">
                            <div v-if="isfollow">
                                <button type="button" class="btn btn-success"
                                    @click="unfollow(post.user_id)">フォロー解除</button>
                            </div>
                            <div v-else>
                                <button type="button" class="btn btn-success"
                                    @click="follow(post.user_id)">フォロー追加</button>
                            </div>
                        </div>
                    </div>
                </div>

                <img :src="imagePath(post)" class="card-img-top">

                <div class="card-body">
                    <p class="card-text">{{ post.content }}</p>
                </div>


                <div class="container mb-2">
                    <div class="row justify-content-between">
                        <div v-if="post.isLiked">
                            <button type="button" class="btn btn-success" @click="unlikepost(post.id)">いいね{{
                                    post.likesCount
                            }}</button>
                        </div>
                        <div v-else>
                            <button type="button" class="btn btn-secondary" @click="likepost(post.id)">いいね{{
                                    post.likesCount
                            }}</button>
                        </div>
                        <div v-if="myPost">
                            <button type="button" class="btn btn-primary" @click="editpost(post.id)">編集</button>
                            <button type="button" class="btn btn-danger" @click="deletepost(post.id)">削除</button>
                        </div>
                    </div>
                </div>
                <div v-for="comment in post.comments">
                    <p>{{ comment.userName + ": " + comment.comment }}</p>
                </div>
                <form @submit.prevent="comitComment()">
                    <div class="input-group mt-1">
                        <input type="text" class="form-control" placeholder="コメント" aria-describedby="button-addon2"
                            v-on:input="commentStr = $event.target.value">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="submit" id="button-addon2">投稿する</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    props: {
        post: {},
    },
    data() {
        return {
            commentStr: String,
        };
    },
    mounted() {
        // console.log('Component mounted.')
    },
    computed: {
        myPost() {
            const curUser = this.$store.getters.getUser
            return (curUser.id == this.post.user_id)
        },
        isfollow() {
            const curUser = this.$store.getters.getUser
            let retVal = false
            curUser.follows.forEach(user => {
                if (user.id == this.post.user_id) {
                    retVal = true
                }
            });

            return retVal
        }
    },
    methods: {
        imagePath(post) {
            return '/storage/' + post.image
        },

        likepost(postId) {
            let url = `/api/like/${postId}`
            axios.post(url)
                .then(Response => {
                    //リダイレクトしてしまうと画面がちらつくのでここで更新
                    this.post.isLiked = true
                    this.post.likesCount++
                })
                .catch(error => { alert(error) })
        },
        unlikepost(postId) {
            let url = `/api/unlike/${postId}`
            axios.delete(url)
                .then(Response => {
                    this.post.isLiked = false
                    this.post.likesCount--
                })
                .catch(error => { alert(error) })
        },
        editpost(postId) {
            let url = `/post/edit/${postId}`
            location.href = url;
        },

        deletepost(postId) {
            let url = `/api/posts/${postId}`
            if (confirm("削除してよろしいですか？")) {
                axios.delete(url)
                    .then(Response => {
                        //リダイレクト
                        location.href = "/"
                    })
                    .catch(error => { alert(error) })
            }
        },
        follow(userId) {
            let url = `/api/follow/${userId}`
            axios.post(url)
                .then(Response => {
                    location.href = "/"
                })
                .catch(error => { alert(error) })
        },
        unfollow(userId) {
            let url = `/api/unfollow/${userId}`
            axios.delete(url)
                .then(Response => {
                    location.href = "/"
                })
                .catch(error => { alert(error) })
        },
        comitComment() {
            let url = `/api/comments`
            axios.post(url, {
                post_id: this.post.id,
                comment: this.commentStr
            })
                .then(Response => {
                    location.href = "/"
                })
                .catch(error => { alert(error) })
        },
    }
}
</script>
