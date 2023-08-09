import React from 'react';
import Skeleton from '@mui/material/Skeleton';
import Box from '@mui/material/Box';
import Stack from "@mui/material/Stack";


const ProjectSkeleton = () => {
    return (
        <Stack spacing={1} sx={{m:1}}>
            <Skeleton variant="text" sx={{ fontSize: '1rem' }} />
            <Skeleton variant="rectangular" fullWidth={true} height={300} />
            <Skeleton variant="rectangular" fullWidth={true} height={300} />
            <Skeleton variant="text" sx={{ fontSize: '1rem' }} />
        </Stack>

    );
}

export default ProjectSkeleton;
