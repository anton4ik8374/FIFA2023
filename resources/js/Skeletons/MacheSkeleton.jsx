import * as React from 'react';
import Skeleton from '@mui/material/Skeleton';
import Stack from '@mui/material/Stack';

export default function MacheSkeleton() {
    return (
        <Stack spacing={1} sx={{m:1}}>
            <Skeleton variant="text" sx={{ fontSize: '1rem' }} />
            <Skeleton variant="circular" width={50} height={50} />
            <Skeleton variant="circular" width={50} height={50} />
            <Skeleton variant="rectangular" fullWidth={true} height={300} />
            <Skeleton variant="rectangular" fullWidth={true} height={40} />
            <Skeleton variant="rectangular" fullWidth={true} height={150} />
            <Skeleton variant="text" sx={{ fontSize: '1rem' }} />
        </Stack>
    );
}
