export type User = {
  id: number
  name: string
  email: string
  emailVerifiedAt: string | null
  createdAt: string | null
  updatedAt: string | null
}

export type Auth = {
  user: User | null
}

/* @chisel-passkeys */
export type Passkey = {
  id: number
  name: string
  authenticator: string | null
  createdAtDiff: string | null
  lastUsedAtDiff: string | null
}
/* @end-chisel-passkeys */

/* @chisel-2fa */
export type TwoFactorConfigContent = {
  title: string
  description: string
  buttonText: string
}
/* @end-chisel-2fa */
