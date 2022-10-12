<template>
    <div class="container mb-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="container">
                        <div class="row justify-content-between">
                            <div>投稿者: {{post.userName }}</div>
                            <button type="button" class="btn btn-success"
                                @click="unfollow(post.user_id)">フォロー解除</button>
                        </div>
                    </div>

                    <div class="card-header">{{post.content }}</div>
                    <img :src="imagePath(post)" width="100%">

                    <div class="container">
                        <div class="row justify-content-between">
                            <div v-if="post.isLiked">
                                <button type="button" class="btn btn-success"
                                    @click="unlikepost(post.id)">いいね{{post.likesCount}}</button>
                            </div>
                            <div v-else>
                                <button type="button" class="btn btn-secondary"
                                    @click="likepost(post.id)">いいね{{post.likesCount}}</button>
                            </div>
                            <td><button type="button" class="btn btn-danger" @click="deletepost(post.id)">削除</button>
                            </td>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Axios from 'axios'

export default {
    props: {
        post: {},
    },
    data() {
        return {

        };
    },
    mounted() {
        // console.log('Component mounted.')
    },
    methods: {
        imagePath(post) {
            return '/storage/' + post.image
        },
        likepost(postId) {
            let url = `/api/like/${postId}`
            Axios.post(url)
                .then(Response => {
                    //リダイレクトしてしまうと画面がちらつくのでここで更新
                    this.post.isLiked = true
                    this.post.likesCount++
                })
                .catch(error => { alert(error) })
        },
        unlikepost(postId) {
            let url = `/api/unlike/${postId}`
            Axios.post(url)
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
                Axios.delete(url)
                    .then(Response => {
                        //リダイレクト
                        location.href = "/"
                    })
                    .catch(error => { alert(error) })
            }
        }
    }
}
</script>
