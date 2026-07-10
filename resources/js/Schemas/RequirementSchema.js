import { z } from 'zod';

export const RequirementSchema = z.object({
    title: z
        .string()
        .trim()
        .min(1, 'Title is required.')
        .max(255, 'Title cannot exceed 255 characters.'),

    description: z
        .string()
        .trim()
        .min(20, 'Description must be at least 20 characters.')
        .max(1000, 'Description cannot exceed 1000 characters.'),

    budget: z.coerce
        .number()
        .min(1, 'Budget must be greater than 0.'),

    location: z
        .string()
        .trim()
        .min(1, 'Location is required.')
        .max(255, 'Location cannot exceed 255 characters.'),
});