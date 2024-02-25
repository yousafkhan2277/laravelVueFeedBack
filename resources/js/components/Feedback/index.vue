<template>
    <div>
      <FeedbackList v-if="!loading && !error" :feedback-list="feedbackList" @fetch-feedback="fetchFeedback" @show-feedback-form="showFeedbackForm = true" @comment-submitted="fetchFeedback" />
  
      <div v-else-if="loading"> <!-- Show loading message if data is still loading -->
        <p>Loading...</p>
      </div>
  
      <div v-else> <!-- Show error message if there's an error -->
        <p>{{ error }}</p>
      </div>
  
      <!-- Modal for creating new feedback -->

          <div class="custom-modal" v-if="showFeedbackForm">
      <div class="custom-modal-content">
        <span class="close" @click="showFeedbackForm = false">&times;</span>
      <FeedbackForm v-if="showFeedbackForm"  @submit-feedback="submitFeedback" />
    </div>
      </div>
    




    
    </div>
  </template>
  
  <script>
  import FeedbackList from './FeedbackList.vue';
  import FeedbackForm from './FeedbackForm.vue';
  
  export default {
    components: {
      FeedbackList,
      FeedbackForm
    },
    data() {
      return {
        feedbackList: [],
        loading: true,
        error: null,
        showFeedbackForm: false
      };
    },
    mounted() {
      this.fetchFeedback();
    },
    methods: {
      fetchFeedback() {
        axios.get('/api/feedback')
          .then(response => {
            this.feedbackList = response.data.data;
            this.loading = false;
          })
          .catch(error => {
            console.error('Error fetching feedback:', error);
            this.error = error.message;
            this.loading = false;
          });
      },
      submitFeedback(newFeedback) {
        axios.post('/api/feedback', newFeedback)
          .then(response => {
            console.log('Feedback submitted successfully');
            this.showFeedbackForm = false;
            this.fetchFeedback();
          })
          .catch(error => {
            console.error('Error submitting feedback:', error);
          });
      }
    }
  };
  </script>

<style scoped>
/* Custom modal styles */
.custom-modal {
  display:  block;
  position: fixed;
  z-index: 1000;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto;
  background-color: rgba(0, 0, 0, 0.4);
}

.custom-modal-content {
  background-color: #fefefe;
  margin: 15% auto;
  padding: 20px;
  border: 1px solid #888;
  width: 70%;
  max-width: 480px;
  position: relative;
}

.close {
  position: absolute;
  top: 10px;
  right: 15px;
  font-size: 28px;
  font-weight: bold;
  cursor: pointer;
}
</style>
  