<div id="family" class="mb-8 tab-content hidden">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold">Family and Relationships</h2>
    </div>

    <!-- Relationship Status Section -->
    <div class="bg-gray-50 rounded-lg p-4 mb-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-medium">Relationship</h3>
            <button class="text-blue-500 hover:text-blue-600" id="editRelationshipBtn">Edit</button>
        </div>
        
        <!-- Relationship Status Display -->
        <div class="bg-white rounded-lg shadow p-4" id="relationship-display">
            <div class="flex items-start space-x-3">
                <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                    <i class="fas fa-heart text-blue-500"></i>
                </div>
                <div>
                    <h4 class="font-medium">Single</h4>
                    <p class="text-gray-500 text-sm">Add your relationship status</p>
                </div>
            </div>
        </div>

        <!-- Relationship Form (Hidden by default) -->
        <div id="relationship-form" class="bg-white rounded-lg shadow p-4 hidden mt-4">
            <div class="space-y-4">
                <div>
                    <label class="block text-gray-700 text-sm font-medium mb-1">Relationship Status</label>
                    <select id="relationship-status" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Select status</option>
                        <option value="Single">Single</option>
                        <option value="In a relationship">In a relationship</option>
                        <option value="Engaged">Engaged</option>
                        <option value="Married">Married</option>
                        <option value="In a civil union">In a civil union</option>
                        <option value="In a domestic partnership">In a domestic partnership</option>
                        <option value="In an open relationship">In an open relationship</option>
                        <option value="It's complicated">It's complicated</option>
                        <option value="Separated">Separated</option>
                        <option value="Divorced">Divorced</option>
                        <option value="Widowed">Widowed</option>
                    </select>
                </div>
                
                <!-- Partner Name (shown only for certain statuses) -->
                <div id="partner-name-container" class="hidden">
                    <label class="block text-gray-700 text-sm font-medium mb-1">Partner's Name</label>
                    <input type="text" id="partner-name" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter name">
                </div>
                
                <!-- Anniversary Date (shown only for certain statuses) -->
                <div id="anniversary-container" class="hidden">
                    <label class="block text-gray-700 text-sm font-medium mb-1">Anniversary Date</label>
                    <div class="grid grid-cols-3 gap-2">
                        <select id="anniversary-month" class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option>Month</option>
                            <option value="1">January</option>
                            <!-- All months would be here -->
                        </select>
                        <select id="anniversary-day" class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option>Day</option>
                            <!-- Days 1-31 would be here -->
                        </select>
                        <select id="anniversary-year" class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option>Year</option>
                            <!-- Years would be here -->
                        </select>
                    </div>
                </div>
                
                <div class="flex justify-end space-x-2">
                    <button class="px-4 py-2 border border-gray-300 rounded-md font-medium cancel-relationship-form">Cancel</button>
                    <button class="px-4 py-2 bg-blue-500 text-white rounded-md font-medium hover:bg-blue-600" id="save-relationship-btn">Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Family Members Section -->
    <div class="bg-gray-50 rounded-lg p-4">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-medium">Family Members</h3>
            <button class="text-blue-500 hover:text-blue-600" id="addFamilyMemberBtn">Add family member</button>
        </div>
        
        <!-- Family Members List -->
        <div class="space-y-3" id="family-members-container">
            <!-- Family members will appear here -->
            <div class="bg-white rounded-lg shadow p-4">
                <p class="text-gray-500 text-sm">Add your family members</p>
            </div>
        </div>

        <!-- Add Family Member Form (Hidden by default) -->
        <div id="family-member-form" class="bg-white rounded-lg shadow p-4 hidden mt-4">
            <div class="space-y-4">
                <div>
                    <label class="block text-gray-700 text-sm font-medium mb-1">Name</label>
                    <input type="text" id="family-member-name" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter name">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-medium mb-1">Relationship</label>
                    <select id="family-relationship" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Select relationship</option>
                        <option value="Parent">Parent</option>
                        <option value="Mother">Mother</option>
                        <option value="Father">Father</option>
                        <option value="Sibling">Sibling</option>
                        <option value="Brother">Brother</option>
                        <option value="Sister">Sister</option>
                        <option value="Child">Child</option>
                        <option value="Son">Son</option>
                        <option value="Daughter">Daughter</option>
                        <option value="Grandparent">Grandparent</option>
                        <option value="Grandmother">Grandmother</option>
                        <option value="Grandfather">Grandfather</option>
                        <option value="Uncle">Uncle</option>
                        <option value="Aunt">Aunt</option>
                        <option value="Cousin">Cousin</option>
                        <option value="Nephew">Nephew</option>
                        <option value="Niece">Niece</option>
                        <option value="Spouse">Spouse</option>
                        <option value="Partner">Partner</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                <div id="custom-relationship-container" class="hidden">
                    <label class="block text-gray-700 text-sm font-medium mb-1">Specify Relationship</label>
                    <input type="text" id="custom-relationship" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter relationship">
                </div>
                <div class="flex justify-end space-x-2">
                    <button class="px-4 py-2 border border-gray-300 rounded-md font-medium cancel-family-member-form">Cancel</button>
                    <button class="px-4 py-2 bg-blue-500 text-white rounded-md font-medium hover:bg-blue-600" id="save-family-member-btn">Save</button>
                </div>
            </div>
        </div>
    </div>
</div>