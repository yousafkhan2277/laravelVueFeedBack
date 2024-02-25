<template>
   <button @click="$emit('show-feedback-form')">Create New Feedback</button>
  <div class="feedback-list">
    <!-- Feedback listing -->
    <div v-if="feedbackList && feedbackList.length > 0">
      <div v-for="feedback in feedbackList" :key="feedback.id" class="feedback-item">
        <div class="post-header">
          <h3>{{ feedback.title }}</h3>
          <p class="category">Category: {{ feedback.category }}</p>
        </div>
        <div class="post-content">
          <p class="user">User: {{ feedback.user.name }}</p>
          <p class="date">Posted on: {{ formatDate(feedback.created_at) }}</p>
        </div>
        
        <!-- Post comment input -->
        <div class="post-comment-input">
          <input type="text" v-model="postInputs[feedback.id]" placeholder="Write a comment..." required @input="checkForUserMentions(feedback.id)">
          <button class="post-comment-btn" @click="submitComment(feedback.id)">Post Comment</button>
          <!-- Dropdown for user mentions -->
          <ul v-if="showUserDropdown && activeFeedbackId === feedback.id" class="user-dropdown">
            <li v-for="user in suggestedUsers" :key="user.id" @click="selectUser(user.name, feedback.id)">
              {{ user.name }}
            </li>
          </ul>
        </div>
        
        <!-- Comments for each feedback item -->
        <div v-for="comment in feedback.comments" :key="comment.id" class="comment">
          <div class="comment-header">
            <p class="comment-info">{{ comment.user.name }} - {{ formatDate(comment.created_at) }}</p>
            <div class="comment-actions">
              <button class="reply-btn" @click="toggleReply(comment.id)">Reply</button>
            </div>
          </div>
          <div class="comment-content" v-html="highlightUserMentions(comment.content)"></div>
          <!-- Reply input -->
          <div v-if="showReplyInput[comment.id]" class="reply-input">
            <input type="text" v-model="replyInputs[comment.id]" placeholder="Write a reply..." required>
            <button class="post-reply-btn" @click="submitReply(feedback.id, comment.id)">Post Reply</button>
          </div>
          
          <!-- Replies -->
          <div v-if="comment.replies && comment.replies.length > 0" class="replies">
            <div v-for="reply in comment.replies" :key="reply.id" class="reply">
              <p class="reply-info">{{ reply.user.name }} - {{ formatDate(reply.created_at) }}</p>
              <div class="reply-content">{{ reply.content }}</div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div v-else>
      <p>No feedback available.</p>
    </div>
  </div>
</template>


<script>
export default {
  props: ['feedbackList'],
  data() {
    return {
      postInputs: {}, // Object to store input values for each post comment
      showUserDropdown: false,
      suggestedUsers: [],
      activeFeedbackId: null, // Track active feedback ID for dropdown
      replyInputs: {}, // Object to store input values for each reply
      showReplyInput: {}, // Object to track visibility of reply inputs
    };
  },
  methods: {
    formatDate(date) {
      // Implement date formatting logic if needed
      return new Date(date).toLocaleString();
    },
    toggleReply(commentId) {
      // Toggle visibility of reply input for the clicked comment
      this.replyInputs[commentId] = '';
      this.showReplyInput[commentId] = !this.showReplyInput[commentId];
      
    },
    checkForUserMentions(feedbackId) {
      const regex = /@(\w+)/g;
      const mentions = this.postInputs[feedbackId].match(regex);
      if (mentions) {
        const query = mentions[mentions.length - 1].substring(1);
        // You need to make an API call to fetch suggested users based on the query
        // For example:
        axios.get(`/api/users?query=${query}`)
          .then(response => {
            this.suggestedUsers = response.data;
            this.activeFeedbackId = feedbackId;
            this.showUserDropdown = true;
          })
          .catch(error => {
            console.error('Error fetching suggested users:', error);
          });
      } else {
        this.showUserDropdown = false;
      }
    },
    selectUser(username, feedbackId) {
      // this.$set(this.postInputs, feedbackId, `${username} `);
      this.postInputs[feedbackId] = ` ${username} `;
      this.showUserDropdown = false;
    },
    highlightUserMentions(content) {
      return content.replace(/@(\w+)/g, '<span class="mention">$&</span>');
    },
    submitComment(feedbackId) {
      axios.post(`/api/feedback/${feedbackId}/comments`, {
        content: this.postInputs[feedbackId]
      })
      .then(response => {
        console.log('Comment submitted successfully');
        this.postInputs[feedbackId] = ''; // Clear comment input
        this.$emit('comment-submitted'); // Emit event to parent component
      })
      .catch(error => {
        console.error('Error submitting comment:', error);
      });
    },
    submitReply(feedbackId, commentId) {
      const replyContent = this.replyInputs[commentId];
      // Make API call to submit reply
      axios.post(`/api/feedback/${feedbackId}/comments/${commentId}/replies`, {
        content: replyContent
      })
      .then(response => {
        console.log('Reply submitted successfully');
        // Clear reply input field after submission
        this.replyInputs[commentId] = '';
        this.$emit('comment-submitted');
        // Refresh feedback list or update specific comment's replies if necessary
        // You may emit an event to parent component to handle this
      })
      .catch(error => {
        console.error('Error submitting reply:', error);
      });
    }
  }
};
</script>


<style scoped>
/* Styles for feedback list */
.feedback-list {
  font-family: Arial, sans-serif;
  width: 100%;
}

/* Styles for feedback item */
.feedback-item {
  background-color: #f7f7f7;
  border: 1px solid #ddd;
  margin-bottom: 20px;
  padding: 10px;
}

/* Styles for post header */
.post-header {
  border-bottom: 1px solid #ddd;
  margin-bottom: 10px;
  padding-bottom: 10px;
}

.post-header h3 {
  margin-top: 0;
  margin-bottom: 5px;
}

/* Styles for post content */
.post-content {
  margin-bottom: 10px;
}

.post-content p {
  margin: 5px 0;
}

/* Styles for comment */
.comment {
  border-bottom: 1px solid #ddd;
  margin-bottom: 10px;
  padding-bottom: 10px;
}

/* Styles for comment header */
.comment-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.comment-info {
  margin: 0;
}

.comment-actions {
  display: flex;
  align-items: center;
}

.reply-btn {
  background-color: #4267b2;
  color: #fff;
  border: none;
  padding: 5px 10px;
  cursor: pointer;
}

.reply-btn:hover {
  background-color: #365899;
}

/* Styles for comment content */
.comment-content {
  margin-bottom: 10px;
}

/* Styles for comment input */
.comment-input {
  display: none;
  margin-bottom: 10px;
}

.comment-input input {
  width: calc(100% - 100px);
  padding: 5px;
  border: 1px solid #ddd;
  border-radius: 3px;
}

.post-reply-btn {
  background-color: #4267b2;
  color: #fff;
  border: none;
  padding: 5px 10px;
  margin-left: 5px;
  cursor: pointer;
}

.post-reply-btn:hover {
  background-color: #365899;
}

/* Styles for replies */
.replies {
  margin-top: 10px;
}

.reply {
  background-color: #f9f9f9;
  border: 1px solid #ddd;
  padding: 5px;
  margin-top: 5px;
}

.reply-info {
  margin: 0;
  font-weight: bold;
}

.reply-content {
  margin-top: 5px;
}
</style>