// This is a simplified Google Sign-In simulation for the prototype
// In a real application, this would integrate with Google OAuth 2.0

// Function to simulate Google Sign-In
function initGoogleSignIn() {
  const googleSignInButton = document.getElementById('google-sign-in-btn');
  
  if (googleSignInButton) {
    googleSignInButton.addEventListener('click', () => {
      // Simulate authentication process
      simulateGoogleAuth();
    });
  }
}

// Simulate Google authentication
function simulateGoogleAuth() {
  // Show loading state
  const loadingElement = document.getElementById('auth-loading');
  if (loadingElement) {
    loadingElement.style.display = 'block';
  }
  
  // Simulate network delay
  setTimeout(() => {
    // Create a dummy user profile (in a real app, this would come from Google)
    const userProfile = {
      type: 'student', // Default to student
      name: 'John Doe',
      email: 'johndoe@example.com',
      picUrl: 'default-user.png',
      phone: '',
      hall: '',
      room: ''
    };
    
    // Save to localStorage
    localStorage.setItem('userProfile', JSON.stringify(userProfile));
    
    // Redirect to index or complete profile page
    window.location.href = 'index.html';
  }, 1500);
}

// Function to check if user is already signed in
function checkGoogleSignIn() {
  return !!localStorage.getItem('userProfile');
}

// Initialize Google Sign-In when the page loads
document.addEventListener('DOMContentLoaded', () => {
  initGoogleSignIn();
  
  // If on login page and already signed in, redirect to index
  const currentPage = window.location.pathname.split('/').pop();
  if (currentPage === 'login.html' && checkGoogleSignIn()) {
    window.location.href = 'index.html';
  }
}); 