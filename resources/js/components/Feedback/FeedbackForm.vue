
  

  <template>
    <form @submit.prevent="submitFeedback" class="feedback-form">
      <!-- Title input with feedback -->
      <div class="form-group">
        <label for="title">Title:</label>
        <input type="text" id="title" v-model="newFeedback.title" @input="validateTitle" required>
        <div v-if="showTitleFeedback" class="feedback">{{ titleFeedback }}</div>
      </div>
      
      <!-- Description input with feedback -->
      <div class="form-group">
        <label for="description">Description:</label>
        <textarea id="description" v-model="newFeedback.description" @input="validateDescription" required></textarea>
        <div v-if="showDescriptionFeedback" class="feedback">{{ descriptionFeedback }}</div>
      </div>
      
      <!-- Category selection with feedback -->
      <div class="form-group">
        <label for="category">Category:</label>
        <select id="category" v-model="newFeedback.category" @change="validateCategory" required>
          <option value="">Select Category</option>
          <option value="bug">Bug Report</option>
          <option value="feature">Feature Request</option>
          <option value="improvement">Improvement</option>
        </select>
        <div v-if="showCategoryFeedback" class="feedback">{{ categoryFeedback }}</div>
      </div>
      
      <!-- Submit button -->
      <button type="submit" :disabled="formInvalid" class="submit-btn">Submit Feedback</button>
    </form>
  </template>
  
  <script>
  export default {
    data() {
      return {
        newFeedback: {
          title: '',
          description: '',
          category: ''
        },
        // Feedback messages
        titleFeedback: '',
        descriptionFeedback: '',
        categoryFeedback: '',
        // Flags to show/hide feedback messages
        showTitleFeedback: false,
        showDescriptionFeedback: false,
        showCategoryFeedback: false
      };
    },
    methods: {
      validateTitle() {
        this.showTitleFeedback = false;
        if (this.newFeedback.title.length < 5) {
          this.titleFeedback = 'Title must be at least 5 characters long';
          this.showTitleFeedback = true;
        }
      },
      validateDescription() {
        this.showDescriptionFeedback = false;
        if (this.newFeedback.description.length < 10) {
          this.descriptionFeedback = 'Description must be at least 10 characters long';
          this.showDescriptionFeedback = true;
        }
      },
      validateCategory() {
        this.showCategoryFeedback = false;
        if (this.newFeedback.category === '') {
          this.categoryFeedback = 'Please select a category';
          this.showCategoryFeedback = true;
        }
      },
      submitFeedback() {
        // Reset feedback messages
        this.titleFeedback = '';
        this.descriptionFeedback = '';
        this.categoryFeedback = '';
        
        // Validate form fields
        this.validateTitle();
        this.validateDescription();
        this.validateCategory();
        
        // Check if form is valid
        if (!this.formInvalid) {
          // Submit feedback logic here
          console.log('Submitting feedback:', this.newFeedback);
          this.$emit('submit-feedback', this.newFeedback);
        }
      }
    },
    computed: {
      // Check if any feedback message is shown
      formInvalid() {
        return this.showTitleFeedback || this.showDescriptionFeedback || this.showCategoryFeedback;
      }
    }
  };
  </script>
  
  <style scoped>
  .feedback-form {
    max-width: 400px;
    margin: 0 auto;
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 5px;
    background-color: #f9f9f9;
  }
  
  .form-group {
    margin-bottom: 20px;
  }
  
  label {
    font-weight: bold;
  }
  
  input[type="text"],
  textarea,
  select {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
  }
  
  .feedback {
    color: red;
    font-size: 12px;
  }
  
  .submit-btn {
    display: block;
    width: 100%;
    padding: 10px;
    border: none;
    border-radius: 5px;
    background-color: #4267b2;
    color: #fff;
    cursor: pointer;
  }
  
  .submit-btn:hover {
    background-color: #365899;
  }
  </style>
  