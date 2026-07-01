<?php

return [
    'login' => 'resources/js/Pages/Auth/Login.vue',
    'register' => 'resources/js/Pages/Auth/Register.vue',
    'welcome' => 'resources/js/Pages/Welcome.vue',
    'profile' => 'resources/js/Pages/Settings/Profile.vue',
    'security' => 'resources/js/Pages/Settings/Security.vue',
    'verify_email' => 'resources/js/Pages/Auth/VerifyEmail.vue',
    'two_factor_challenge' => 'resources/js/Pages/Auth/TwoFactorChallenge.vue',
    'confirm_password' => 'resources/js/Pages/Auth/ConfirmPassword.vue',
    'auth_types' => 'resources/js/Types/auth.ts',

    'two_factor_files' => [
        'resources/js/Components/ManageTwoFactor.vue',
        'resources/js/Components/TwoFactorSetupModal.vue',
        'resources/js/Components/TwoFactorRecoveryCodes.vue',
        'resources/js/Components/Base/InputOTP/index.ts',
        'resources/js/Components/Base/InputOTP/InputOTP.vue',
        'resources/js/Components/Base/InputOTP/InputOTPGroup.vue',
        'resources/js/Components/Base/InputOTP/InputOTPSeparator.vue',
        'resources/js/Components/Base/InputOTP/InputOTPSlot.vue',
        'resources/js/Composables/useTwoFactorAuth.ts',
    ],

    'two_factor_otp_package' => 'vue-input-otp',

    'passkey_files' => [
        'resources/js/Components/PasskeyItem.vue',
        'resources/js/Components/ManagePasskeys.vue',
        'resources/js/Components/PasskeyRegister.vue',
        'resources/js/Components/PasskeyVerify.vue',
    ],
];
