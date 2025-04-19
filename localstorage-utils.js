// localStorage utility functions

// User Profile operations
function saveUserProfile(userProfile) {
  localStorage.setItem('userProfile', JSON.stringify(userProfile));
}

function getUserProfile() {
  const profile = localStorage.getItem('userProfile');
  return profile ? JSON.parse(profile) : null;
}

// Tray operations
function saveTray(tray) {
  localStorage.setItem('tray', JSON.stringify(tray));
}

function getTray() {
  const tray = localStorage.getItem('tray');
  return tray ? JSON.parse(tray) : [];
}

function addToTray(item) {
  const tray = getTray();
  
  // Check if item already exists
  const existingItemIndex = tray.findIndex(
    i => i.vendorId === item.vendorId && i.itemId === item.itemId
  );
  
  if (existingItemIndex >= 0) {
    // Update quantity if item exists
    tray[existingItemIndex].qty += item.qty;
  } else {
    // Add new item
    tray.push(item);
  }
  
  saveTray(tray);
}

function removeFromTray(vendorId, itemId) {
  const tray = getTray();
  const updatedTray = tray.filter(
    item => !(item.vendorId === vendorId && item.itemId === itemId)
  );
  saveTray(updatedTray);
}

function clearTray() {
  localStorage.removeItem('tray');
}

// Orders operations
function saveOrders(orders) {
  localStorage.setItem('orders', JSON.stringify(orders));
  // Also save to sessionStorage for persistence across sessions
  sessionStorage.setItem('sapaspots_orders', JSON.stringify(orders));
}

// Helper function to get orders from cookies
function getOrdersFromCookie() {
  const cookies = document.cookie.split(';');
  for (let i = 0; i < cookies.length; i++) {
    const cookie = cookies[i].trim();
    if (cookie.startsWith('sapaspots_orders=')) {
      try {
        const orderString = decodeURIComponent(cookie.substring('sapaspots_orders='.length));
        return JSON.parse(orderString);
      } catch (e) {
        console.error('Error parsing orders cookie', e);
        return null;
      }
    }
  }
  return null;
}

function getOrders() {
  // First try to get from localStorage
  const localOrders = localStorage.getItem('orders');
  
  if (localOrders) {
    return JSON.parse(localOrders);
  }
  
  // If not found in localStorage, try sessionStorage
  const sessionOrders = sessionStorage.getItem('sapaspots_orders');
  
  // If found in sessionStorage, restore to localStorage
  if (sessionOrders) {
    const orders = JSON.parse(sessionOrders);
    localStorage.setItem('orders', JSON.stringify(orders));
    return orders;
  }
  
  // Try to get from cookies as last resort
  const cookieOrders = getOrdersFromCookie();
  if (cookieOrders) {
    localStorage.setItem('orders', JSON.stringify(cookieOrders));
    sessionStorage.setItem('sapaspots_orders', JSON.stringify(cookieOrders));
    return cookieOrders;
  }
  
  // If not found anywhere, return empty array
  return [];
}

function addOrder(order) {
  const orders = getOrders();
  orders.push(order);
  saveOrders(orders);
  
  // For extra redundancy, also store in a separate cookie
  try {
    const ordersCookie = JSON.stringify(orders);
    document.cookie = `sapaspots_orders=${encodeURIComponent(ordersCookie)};path=/;max-age=86400`;
  } catch (e) {
    console.error('Failed to save orders cookie', e);
  }
}

function updateOrderStatus(orderId, status) {
  const orders = getOrders();
  const orderIndex = orders.findIndex(order => order.orderId === orderId);
  
  if (orderIndex >= 0) {
    orders[orderIndex].status = status;
    saveOrders(orders);
    return true;
  }
  
  return false;
}

// Vendors operations
function saveVendors(vendors) {
  localStorage.setItem('vendors', JSON.stringify(vendors));
}

function getVendors() {
  const vendors = localStorage.getItem('vendors');
  return vendors ? JSON.parse(vendors) : [];
}

function updateVendorStatus(vendorId, isOpen) {
  const vendors = getVendors();
  const vendorIndex = vendors.findIndex(vendor => vendor.vendorId === vendorId);
  
  if (vendorIndex >= 0) {
    vendors[vendorIndex].open = isOpen;
    saveVendors(vendors);
    return true;
  }
  
  return false;
}

function updateItemAvailability(vendorId, itemId, available) {
  const vendors = getVendors();
  const vendorIndex = vendors.findIndex(vendor => vendor.vendorId === vendorId);
  
  if (vendorIndex >= 0) {
    const itemIndex = vendors[vendorIndex].menu.findIndex(item => item.itemId === itemId);
    
    if (itemIndex >= 0) {
      vendors[vendorIndex].menu[itemIndex].available = available;
      saveVendors(vendors);
      return true;
    }
  }
  
  return false;
} 