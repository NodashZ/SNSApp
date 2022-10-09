<template>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <post-message title="投稿フォーム" content="コメントと画像を登録"> </post-message>
            <form @submit.prevent="savepost">

                <div class="form-group">
                    <label for="content">
                        内容
                    </label>
                    <textarea id="content" name="content" class="form-control" rows="4"
                        v-model="post.content"></textarea>
                </div>
                <div class="form-group">
                    <label for="image">
                        画像
                    </label>
                    <div v-if="imageurl">
                        <img :src="post.image" width="100%">
                    </div>
                    <input class="form-control" @change="uploadFile" type="file" required>
                </div>

                <div class="mt-5">
                    <a class="btn btn-secondary" href="/">
                        キャンセル
                    </a>
                    <button type="submit" class="btn btn-primary">
                        投稿する
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
            post: {},
            fileInfo:'',
            imageurl:"",
        };
    },
    created() {
        this.post.image = ""
    },
    computed: {
        
    },
    methods: {
        savepost() {
            let url = `/api/fileupload`
            if (confirm("送信してよろしいですか？")) {
                Axios.post(url, {
                    post: this.post,
                    fileInfo: this.fileInfo,
                })
                    .then(Response => {
                        //リダイレクト
                        // location.href = "/"
                    })
                    .catch(error => { alert(error) })
            }
        },
        uploadFile(event) {
            if (this.post.image.length){
                URL.revokeObjectURL(this.post.image);
            }
            this.fileInfo = event.target.files[0];
            if(this.fileInfo != void 0) {
                this.post.image = this.imageurl = URL.createObjectURL(this.fileInfo)
            } else {
                this.post.image = this.imageurl = ""
            }
        }
    }
}

</script>