export type Guard = Record<string, { fallback: string }>

const guards = {
  staff: {
    fallback: 'staff-login',
  },
} as Guard

export default guards
