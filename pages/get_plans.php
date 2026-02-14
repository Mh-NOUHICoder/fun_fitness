<?php
session_start();
include('../assets/include/config.php');

try {
    // Get member count for each plan
    $planStats = [];
    $statsStmt = $con->query("
        SELECT m.type, COUNT(mem.member_id) as member_count 
        FROM memberships m 
        LEFT JOIN members mem ON m.membership_id = mem.membership_id 
        GROUP BY m.membership_id
    ");
    $planStats = $statsStmt->fetchAll(PDO::FETCH_ASSOC);

    // Fetch existing plans
    $req = $con->query("
        SELECT m.*, p.price, p.service_name, p.description as price_description 
        FROM memberships m 
        LEFT JOIN prices p ON m.id_price = p.price_id 
        ORDER BY m.membership_id DESC
    ");
    $existingPlans = $req->fetchAll(PDO::FETCH_ASSOC);

    foreach ($existingPlans as $plan): 
        $memberCount = 0;
        foreach ($planStats as $stat) {
            if ($stat['type'] === $plan['type']) {
                $memberCount = $stat['member_count'];
                break;
            }
        }
?>
<div class="plan-strip active-plan" id="plan-<?= $plan['membership_id'] ?>">
    <div class="strip-icon" style="background: rgba(16, 185, 129, 0.1); color: #10b981;">
        <i class="fas fa-check-circle"></i>
    </div>
    
    <div class="strip-info">
        <h3><?= htmlspecialchars($plan['type']) ?></h3>
        <p><?= htmlspecialchars($plan['description']) ?></p>
    </div>
    
    <div class="strip-features">
        <span class="feature-tag"><i class="fas fa-users me-1"></i> <?= $memberCount ?> Members</span>
        <span class="feature-tag"><i class="fas fa-clock me-1"></i> <?= htmlspecialchars($plan['duration']) ?> Months</span>
    </div>
    
    <div class="strip-price">
        <span class="price-large">$<?= number_format($plan['price'], 2) ?></span>
        <span class="price-period">per term</span>
    </div>
    
    <div class="strip-action">
        <button class="btn-strip btn-remove remove-plan-btn" 
                data-plan-id="<?= $plan['membership_id'] ?>"
                data-plan-name="<?= htmlspecialchars($plan['type']) ?>">
            <i class="fas fa-trash-alt"></i>
        </button>
    </div>
</div>
<?php endforeach;
} catch (Exception $e) {
    echo '<div class="text-center text-muted">Error loading plans</div>';
}
?>