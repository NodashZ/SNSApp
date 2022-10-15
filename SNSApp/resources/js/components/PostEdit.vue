<template>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <post-message title="投稿編集フォーム" content="コメントと画像を編集"> </post-message>
            <form @submit.prevent="updatepost">

                <div class="form-group">
                    <label for="content">
                        内容
                    </label>
                    <textarea id="content" name="content" class="form-control" rows="4"
                        v-model="post.content" required></textarea>
                </div>
                <div class="form-group">
                    <label for="image">
                        画像
                    </label>
                    <div v-if="imageurl">
                        <img :src="imageurl" width="100%">
                    </div>
                </div>

                <div class="mt-5">
                    <a class="btn btn-secondary" href="/">
                        キャンセル
                    </a>
                    <button type="submit" class="btn btn-primary">
                        更新する
                    </button>
                </div>

            </form>
        </div>
    </div>
</template>
<script>
import Axios from 'axios'

export default {
    data() {
        return {
            postId: 0,
            post: {},
            fileInfo:'',
            imageurl:"",
        };
    },
    created() {
        this.postId = location.pathname.substring(location.pathname.lastIndexOf('/') + 1)
        let url = `/api/posts/${this.postId}`
        this.fetchTodo(url)    },
    computed: {
        
    },
    methods: {
        fetchTodo(url) {
            Axios.get(url)
                .then(response => {
                    this.post = response.data.data
                    this.imageurl = '/storage/' + this.post.image
                })
                .catch(error => { alert(error) })
        },
        updatepost() { 
            let url = `/api/posts/${this.postId}`
            if (confirm("更新してよろしいですか？")) {
                Axios.put(url, {
                    post: this.post,
                   })
                    .then(Response => {
                        //リダイレクト
                        location.href = "/"
                    })
                    .catch(error => { alert(error) })
            }
        },
        
    }
}

</script>