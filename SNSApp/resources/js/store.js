import Vue from 'vue'
import Vuex from 'vuex'
 
Vue.use(Vuex)
 
export default new Vuex.Store({
 
  // 共有するデータ
  state: {
    user: {},
  },
  
  // ミューテーション
  // ※stateのデータ変更はミューテーションが行う
  mutations: {
    setUser(state, user) {
      state.user = user;
    }
  },
  
  // ゲッター
  getters: {
    getUser(state) {
      return state.user;
    }
  },
  
  // アクション
  actions: {
    setUserAction(context, payload) {
      context.commit('setUser', payload);
    }    
  }    
})