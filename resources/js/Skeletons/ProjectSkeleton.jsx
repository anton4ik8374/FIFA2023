import React from 'react';
import Skeleton from '@mui/material/Skeleton';
import Box from '@mui/material/Box';


const ProjectSkeleton = () => {
    return (
        <>
            <Box component="main">
                <Skeleton/>
                <Skeleton animation={false}/>
                <Skeleton animation="wave"/>
                <Skeleton animation="wave"/>
                <Skeleton variant="rect" width={'100%'} height={'80vh'} />
                <Skeleton/>
                <Skeleton animation={false}/>
                <Skeleton animation="wave"/>
                <Skeleton animation="wave"/>
            </Box>
        </>

    );
}

export default ProjectSkeleton;
