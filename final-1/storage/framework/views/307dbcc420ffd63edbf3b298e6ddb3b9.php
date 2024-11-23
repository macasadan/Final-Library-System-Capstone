

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-6">
    <h2 class="text-3xl font-bold mb-6 text-gray-800">PC Room Management</h2>

    <!-- Current Status -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-lg font-semibold mb-2">Current Occupancy</h3>
            <p class="text-3xl font-bold <?php echo e($occupancy >= $maxCapacity ? 'text-red-600' : 'text-green-600'); ?>">
                <?php echo e($occupancy); ?>/<?php echo e($maxCapacity); ?>

            </p>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-lg font-semibold mb-2">Active Sessions</h3>
            <p class="text-3xl font-bold text-blue-600"><?php echo e(count($activeSessions)); ?></p>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-lg font-semibold mb-2">Pending Requests</h3>
            <p class="text-3xl font-bold text-yellow-600"><?php echo e($pendingRequests); ?></p>
        </div>
    </div>

    <!-- Pending Requests -->
    <div class="bg-white rounded-lg shadow-md mb-6">
        <div class="p-6">
            <h3 class="text-xl font-semibold mb-4">Pending Access Requests</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Request Time</th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Purpose</th>
                            <th class="px-6 py-3 bg-gray-50 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php $__empty_1 = true; $__currentLoopData = $pendingSessions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $session): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <?php if($session && $session->id): ?>
                        <tr id="pending-session-<?php echo e($session->id); ?>">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php echo e($session->user ? $session->user->name : 'N/A'); ?>

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php echo e($session->created_at ? $session->created_at->diffForHumans() : 'N/A'); ?>

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php echo e($session->purpose ?? 'N/A'); ?>

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <button type="button"
                                    class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 mr-2"
                                    onclick="handleApproveSession('<?php echo e($session->id); ?>')">
                                    Approve
                                </button>
                                <button type="button"
                                    class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600"
                                    onclick="handleRejectSession('<?php echo e($session->id); ?>')">
                                    Reject
                                </button>
                            </td>
                        </tr>
                        <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                No pending requests
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Active Sessions -->
    <div class="bg-white rounded-lg shadow-md">
        <div class="p-6">
            <h3 class="text-xl font-semibold mb-4">Active Sessions</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Start Time</th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time Remaining</th>
                            <th class="px-6 py-3 bg-gray-50 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php $__empty_1 = true; $__currentLoopData = $activeSessions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $session): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <?php if($session && $session->id): ?>
                        <tr id="active-session-<?php echo e($session->id); ?>">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php echo e($session->user ? $session->user->name : 'N/A'); ?>

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php echo e($session->start_time ? $session->start_time->format('H:i:s') : 'N/A'); ?>

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php if($session->end_time): ?>
                                <span class="timer"
                                    data-end="<?php echo e($session->end_time->timestamp * 1000); ?>"
                                    data-session-id="<?php echo e($session->id); ?>">
                                    Calculating...
                                </span>
                                <?php else: ?>
                                <span>N/A</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <button type="button"
                                    class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600"
                                    onclick="handleEndSession('<?php echo e($session->id); ?>')">
                                    End Session
                                </button>
                            </td>
                        </tr>
                        <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                No active sessions
                            </td>
                        </tr>
                        <?php endif; ?>

                        <?php $__env->startPush('scripts'); ?>
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

                                // Utility function to format time
                                function formatTime(minutes, seconds) {
                                    return `${minutes}:${seconds.toString().padStart(2, '0')}`;
                                }

                                // Timer update function
                                function updateTimers() {
                                    const now = Date.now(); // Current time in milliseconds

                                    document.querySelectorAll('.timer').forEach(timer => {
                                        const endTime = parseInt(timer.dataset.end); // Already in milliseconds
                                        const sessionId = timer.dataset.sessionId;
                                        const diff = endTime - now;

                                        // If timer hasn't been marked as expired and time is up
                                        if (diff <= 0 && !timer.dataset.expired) {
                                            timer.textContent = 'Session Expired';
                                            timer.classList.add('text-red-600');
                                            timer.dataset.expired = 'true';

                                            // Handle expired session
                                            handleExpiredSession(sessionId);
                                            return;
                                        }

                                        // If not expired, update the display
                                        if (diff > 0) {
                                            const minutes = Math.floor(diff / 60000);
                                            const seconds = Math.floor((diff % 60000) / 1000);

                                            // Add warning class when less than 5 minutes remaining
                                            if (minutes < 5) {
                                                timer.classList.add('text-yellow-600');
                                            } else {
                                                timer.classList.remove('text-yellow-600');
                                            }

                                            timer.textContent = formatTime(minutes, seconds);
                                        }
                                    });
                                }

                                // Handle expired session
                                async function handleExpiredSession(sessionId) {
                                    try {
                                        const response = await fetch(`/admin/pc-room/end-session/${sessionId}`, {
                                            method: 'POST',
                                            headers: {
                                                'Content-Type': 'application/json',
                                                'X-CSRF-TOKEN': csrfToken
                                            }
                                        });

                                        if (!response.ok) {
                                            throw new Error('Failed to end expired session');
                                        }

                                        // Optionally reload the page or update the UI
                                        // window.location.reload();
                                    } catch (error) {
                                        console.error('Error handling expired session:', error);
                                    }
                                }
                                // End session handler
                                window.handleEndSession = async function(sessionId) {
                                    if (!confirm('Are you sure you want to end this session?')) {
                                        return;
                                    }

                                    try {
                                        const response = await fetch(`/admin/pc-room/end-session/${sessionId}`, {
                                            method: 'POST',
                                            headers: {
                                                'Content-Type': 'application/json',
                                                'X-CSRF-TOKEN': csrfToken
                                            }
                                        });

                                        if (!response.ok) {
                                            throw new Error('Failed to end session');
                                        }

                                        // Remove the session row or reload the page
                                        const sessionRow = document.getElementById(`active-session-${sessionId}`);
                                        if (sessionRow) {
                                            sessionRow.remove();
                                        }
                                        // Reload to update the counts and status
                                        window.location.reload();

                                    } catch (error) {
                                        alert('Error ending session: ' + error.message);
                                    }
                                };


                                // Approve session handler
                                window.handleApproveSession = async function(sessionId) {
                                    if (!confirm('Are you sure you want to approve this request?')) {
                                        return;
                                    }

                                    try {
                                        const response = await fetch(`/admin/pc-room/approve/${sessionId}`, {
                                            method: 'POST',
                                            headers: {
                                                'Content-Type': 'application/json',
                                                'X-CSRF-TOKEN': csrfToken
                                            }
                                        });

                                        if (!response.ok) {
                                            throw new Error('Failed to approve session');
                                        }

                                        // Reload the page to show updated session status
                                        window.location.reload();
                                    } catch (error) {
                                        alert('Error approving session: ' + error.message);
                                    }
                                };

                                // Reject session handler
                                window.handleRejectSession = async function(sessionId) {
                                    if (!confirm('Are you sure you want to reject this request?')) {
                                        return;
                                    }

                                    try {
                                        const response = await fetch(`/admin/pc-room/reject/${sessionId}`, {
                                            method: 'POST',
                                            headers: {
                                                'Content-Type': 'application/json',
                                                'X-CSRF-TOKEN': csrfToken
                                            }
                                        });

                                        if (!response.ok) {
                                            throw new Error('Failed to reject session');
                                        }

                                        // Remove the session row or reload the page
                                        const sessionRow = document.getElementById(`pending-session-${sessionId}`);
                                        if (sessionRow) {
                                            sessionRow.remove();
                                        }
                                        // Reload to update the counts and status
                                        window.location.reload();
                                    } catch (error) {
                                        alert('Error rejecting session: ' + error.message);
                                    }
                                };
                                // Initialize timer updates
                                updateTimers();
                                // Update every second
                                setInterval(updateTimers, 1000);

                                // Request notification permission
                                if ('Notification' in window) {
                                    Notification.requestPermission();
                                }
                            });
                        </script>
                        <?php $__env->stopPush(); ?>

                        <?php $__env->startPush('styles'); ?>
                        <style>
                            .timer {
                                font-family: monospace;
                                font-size: 1.1em;
                            }

                            .timer.text-red-600 {
                                font-weight: bold;
                            }
                        </style>
                        <?php $__env->stopPush(); ?>
                        <?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\dashboard\FINAL_CPSTN\final-1\resources\views/admin/pc-room/dashboard.blade.php ENDPATH**/ ?>