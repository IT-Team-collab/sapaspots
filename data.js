// Sample data for the application
// This will serve as our temporary backend database

// Initialize data if not already in localStorage
(function initializeData() {
  // Check if vendors data exists
  if (!localStorage.getItem('vendors')) {
    // Sample vendors data
    const vendors = [
      {
        vendorId: 'v1',
        name: 'THE CAMPUS BARBEQUE CENTRE',
        location: '6GGJ8HMC+FQCW Makerere University, Kampala',
        open: true,
        rating: 4.8,
        reviews: 120,
        menu: [
          { itemId: 'i1', name: 'BBQ Chicken', price: 15000, available: true },
          { itemId: 'i2', name: 'BBQ Pork Ribs', price: 18000, available: true },
          { itemId: 'i3', name: 'BBQ Beef', price: 16000, available: true },
          { itemId: 'i4', name: 'BBQ Platter', price: 25000, available: true },
          { itemId: 'i5', name: 'Chips', price: 5000, available: true }
        ]
      },
      {
        vendorId: 'v2',
        name: 'Best Foods Restaurant',
        location: '8HH9+9M9, Makerere Hill Rd, Kampala',
        open: true,
        rating: 4.6,
        reviews: 85,
        menu: [
          { itemId: 'i6', name: 'Local Food Platter', price: 12000, available: true },
          { itemId: 'i7', name: 'Chicken Curry', price: 14000, available: true },
          { itemId: 'i8', name: 'Beef Stew', price: 13000, available: true },
          { itemId: 'i9', name: 'Vegetable Rice', price: 8000, available: true }
        ]
      },
      {
        vendorId: 'v3',
        name: 'Crave Cave Takeaway Restaurant',
        location: 'Makerere Kikoni, Makerere',
        open: true,
        rating: 4.5,
        reviews: 65,
        menu: [
          { itemId: 'i10', name: 'Chicken Wings', price: 12000, available: true },
          { itemId: 'i11', name: 'Burger Combo', price: 15000, available: true },
          { itemId: 'i12', name: 'Pizza Slice', price: 8000, available: true },
          { itemId: 'i13', name: 'Steak Sandwich', price: 16000, available: true },
          { itemId: 'i14', name: 'Fries', price: 5000, available: true }
        ]
      },
      {
        vendorId: 'v4',
        name: 'Campus Grill',
        location: 'Main Campus Food Court',
        open: true,
        rating: 4.2,
        reviews: 50,
        menu: [
          { itemId: 'i15', name: 'Chicken Burger', price: 12000, available: true },
          { itemId: 'i16', name: 'Beef Burger', price: 15000, available: true },
          { itemId: 'i17', name: 'French Fries', price: 8000, available: true },
          { itemId: 'i18', name: 'Chicken & Chips', price: 18000, available: true },
          { itemId: 'i19', name: 'Soda', price: 3000, available: true }
        ]
      },
      {
        vendorId: 'v5',
        name: 'Rolex King',
        location: 'Engineering Block',
        open: true,
        rating: 4.0,
        reviews: 75,
        menu: [
          { itemId: 'i20', name: 'Plain Rolex', price: 5000, available: true },
          { itemId: 'i21', name: 'Rolex with Meat', price: 7000, available: true },
          { itemId: 'i22', name: 'Double Egg Rolex', price: 6000, available: true },
          { itemId: 'i23', name: 'Kikomando', price: 4000, available: true }
        ]
      },
      {
        vendorId: 'v6',
        name: 'African Cuisine',
        location: 'Complex Hall',
        open: false,
        rating: 3.8,
        reviews: 40,
        menu: [
          { itemId: 'i24', name: 'Matooke & Groundnut', price: 10000, available: true },
          { itemId: 'i25', name: 'Posho & Beans', price: 8000, available: true },
          { itemId: 'i26', name: 'Rice & Chicken', price: 15000, available: true },
          { itemId: 'i27', name: 'Local Fish', price: 20000, available: true },
          { itemId: 'i28', name: 'Vegetable Platter', price: 7000, available: true }
        ]
      },
      {
        vendorId: 'v7',
        name: 'Campus Coffee',
        location: 'Library Block',
        open: true,
        rating: 4.3,
        reviews: 60,
        menu: [
          { itemId: 'i29', name: 'Espresso', price: 6000, available: true },
          { itemId: 'i30', name: 'Cappuccino', price: 8000, available: true },
          { itemId: 'i31', name: 'Milk Tea', price: 4000, available: true },
          { itemId: 'i32', name: 'Black Tea', price: 3000, available: true },
          { itemId: 'i33', name: 'Pastry', price: 5000, available: true }
        ]
      }
    ];
    
    // Store in localStorage
    localStorage.setItem('vendors', JSON.stringify(vendors));
  }
  
  // Initialize empty orders array if not exists
  if (!localStorage.getItem('orders')) {
    localStorage.setItem('orders', JSON.stringify([]));
  }
  
  // Initialize empty tray if not exists
  if (!localStorage.getItem('tray')) {
    localStorage.setItem('tray', JSON.stringify([]));
  }
})(); 