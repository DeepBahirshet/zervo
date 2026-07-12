import { z } from 'zod';

export const ApplicationSchema = z.object({
    message: z
        .string()
        .trim()
        .min(1, 'Title is required.')
        .max(255, 'Title cannot exceed 255 characters.'),

    quoted_price: z.coerce
        .number()
        .min(1, 'Price must be greater than 0.'),

    estimated_days: z.coerce
        .number()
        .positive('Estimated days must be greater than 0.')
});